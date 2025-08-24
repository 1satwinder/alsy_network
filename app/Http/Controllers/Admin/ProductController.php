<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\ProductListBuilder;
use App\Models\Category;
use App\Models\CompanyStockLedger;
use App\Models\GSTType;
use App\Models\Product;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Sentry;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Str;
use Throwable;

class ProductController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return ProductListBuilder::render();
    }

    public function create(): Renderable
    {
        return view('admin.product.create', [
            'categories' => Category::with([
                'children' => function ($query) {
                    return $query->where('status', Category::STATUS_ACTIVE);
                },
            ])->where('status', Category::STATUS_ACTIVE)
                ->whereNull('parent_id')
                ->get(),
            'gstTypes' => GSTType::get(),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): Renderable|RedirectResponse
    {
        $rules = [
            'name' => 'required|unique:products,name,max:255',
            'category_id' => [
                'required', Rule::exists('categories', 'id')->whereNotNull('parent_id'),
            ],
            'sku' => 'required|unique:products,sku',
            'mrp' => 'required|numeric|min:1',
            'dp' => 'required|numeric|lte:mrp|min:1',
            'bv' => 'required|numeric|min:1',
            'opening_stock' => 'required|numeric|min:1',
            'image' => 'required',
            'description' => 'nullable',
            'g_s_t_type_id' => 'required|exists:g_s_t_types,id',
        ];

        $validated = $this->validate($request, $rules, [
            'sku.required' => 'The product code is required',
            'sku.unique' => 'The product code has already been taken',
            'g_s_t_type_id.required' => 'The HSN No is required',
            'name.required' => 'The product name is required',
        ]);

        try {
            return DB::transaction(function () use ($request, $validated) {
                $product = Product::create(
                    collect($validated)->except('image')->merge(['company_stock' => $validated['opening_stock']])->toArray()
                );

                $product->companyStockLedger()->create([
                    'product_id' => $product->id,
                    'type' => CompanyStockLedger::TYPE_INWARD,
                    'quantity' => $request->get('opening_stock'),
                    'amount' => $request->get('dp') * $request->get('opening_stock'),
                ]);

                if ($fileName = $request->get('image')) {
                    $filePath = 'tmp/'.Str::beforeLast($fileName, '.');

                    $product->addMediaFromDisk($filePath)
                        ->usingFileName($fileName)
                        ->toMediaCollection(Product::MC_PRODUCT_IMAGE);
                }

                if ($request->get('sub_images')) {
                    foreach ($request->get('sub_images') as $fileName) {
                        $filePath = 'tmp/'.Str::beforeLast($fileName, '.');

                        $product->addMediaFromDisk($filePath)
                            ->usingFileName($fileName)
                            ->toMediaCollection(Product::MC_PRODUCT_SUB_IMAGE);
                    }
                }

                return redirect()->route('admin.products.index')->with(['success' => 'Product created successfully']);
            });
        } catch (Throwable $e) {
            Sentry::captureException($e);

            return redirect()->back()->with(['error' => 'Something went wrong. Please try again'])->withInput();
        }
    }

    public function edit(Product $product): Renderable
    {
        return view('admin.product.edit', [
            'categories' => Category::with([
                'children' => function ($query) {
                    return $query->where('status', Category::STATUS_ACTIVE);
                },
            ])->where('status', Category::STATUS_ACTIVE)
                ->whereNull('parent_id')
                ->get(),
            'product' => $product,
            'subImages' => $product->getMedia(Product::MC_PRODUCT_SUB_IMAGE),
            'gstTypes' => GSTType::get(),
        ]);
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     * @throws ValidationException
     */
    public function update(Request $request, Product $product): Renderable|RedirectResponse
    {
        $rules = [
            'name' => [
                'required',
                Rule::unique('products', 'name')->ignore($product->id),
            ],
            'sku' => [
                'required',
                Rule::unique('products', 'sku')->ignore($product->id),
            ],
            'mrp' => 'required|numeric|min:1',
            'dp' => 'required|numeric|lte:mrp|min:1',
            'bv' => 'required|numeric|min:1',
            'qty' => 'nullable|numeric|min:1',
            'status' => 'required',
            'g_s_t_type_id' => 'required|exists:g_s_t_types,id',
        ];

        $this->validate($request, $rules, [
            'sku.required' => 'The product code is required',
            'g_s_t_type_id.required' => 'The HSN No is required',
        ]);

        $product->category_id = $request->get('category_id');
        $product->name = $request->get('name');
        $product->g_s_t_type_id = $request->get('g_s_t_type_id');
        $product->sku = $request->get('sku');
        $product->mrp = $request->get('mrp');
        $product->dp = $request->get('dp');
        $product->bv = $request->get('bv');
        $product->description = $request->get('description');
        $product->status = $request->get('status');

        if ($request->get('qty') > 0) {
            $product->company_stock = $product->company_stock + $request->get('qty');
        }

        $product->save();

        if ($fileName = $request->get('product_image')) {
            $filePath = 'tmp/'.Str::beforeLast($fileName, '.');

            $product->addMediaFromDisk($filePath)
                ->usingFileName($fileName)
                ->toMediaCollection(Product::MC_PRODUCT_IMAGE);
        }

        $product->clearMediaCollection(Product::MC_PRODUCT_SUB_IMAGE);

        if ($request->get('sub_images')) {
            foreach ($request->get('sub_images') as $fileName) {
                $filePath = 'tmp/'.Str::beforeLast($fileName, '.');

                $product->addMediaFromDisk($filePath)
                    ->usingFileName($fileName)
                    ->toMediaCollection(Product::MC_PRODUCT_SUB_IMAGE);
            }
        }

        return redirect()->route('admin.products.index')->with(['success' => 'Product Updated Successfully']);
    }

    /**
     * @throws Throwable
     */
    public function statusUpdate(Request $request): RedirectResponse
    {
        if ($request->get('changeStatus')) {
            if (count($request->get('products')) > 0) {
                DB::transaction(function () use ($request) {
                    Product::whereIn('id', $request->get('products'))
                        ->update(['status' => $request->get('changeStatus')]);
                });

                return redirect()->back()->with(['success' => 'Product status changed successfully']);
            }

            return redirect()->back()->with(['error' => 'Please select products']);
        }

        return redirect()->back()->with(['error' => 'Please select status']);
    }
}
