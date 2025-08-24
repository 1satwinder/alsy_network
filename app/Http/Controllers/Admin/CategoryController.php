<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\CategoryListBuilder;
use App\Models\Category;
use App\Models\Product;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class CategoryController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request, ?Category $parent = null): Renderable|JsonResponse|RedirectResponse
    {
        return CategoryListBuilder::render(extras: ['parent_id' => $parent?->id], name: $parent ? 'Sub Category -'.$parent->name : null);
    }

    public function create(Request $request): Renderable
    {
        $categories = Category::whereNull('parent_id')
            ->where('status', Category::STATUS_ACTIVE)
            ->get();

        return view('admin.category.create', ['categories' => $categories]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name',
        ], [
            'name.required' => 'The category name is required',
        ]);

        //        if (!$request->get('parent_id')) {
        //            if (Category::whereNull('parent_id')->whereStatus(Category::STATUS_ACTIVE)->count() >= 8) {
        //                return redirect()->back()->with(['error' => 'you can not add more than 8 category as parent']);
        //            }
        //        }

        $category = Category::Create([
            'name' => $request->get('name'),
            'status' => Category::STATUS_ACTIVE,
        ]);

        if ($request->get('parent_id')) {
            $category->parent_id = $request->get('parent_id');
            $category->save();
        }

        return redirect()->route('admin.categories.index', $category->parent_id)->with(['success' => 'Category added successfully']);
    }

    public function edit(Category $category): Renderable|RedirectResponse
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('status', Category::STATUS_ACTIVE)
            ->where('name', '!=', $category->name)->get();

        return view('admin.category.edit', ['category' => $category, 'parentCategories' => $parentCategories]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
        ], [
            'name.required' => 'The category name is required',
        ]);

        if ($request->get('parent_id')) {
            $category->parent_id = $request->get('parent_id');
            $message = 'Sub Category updated successfully';
        } else {
            $category->parent_id = null;
            $message = 'Category updated successfully';
        }

        $category->name = $request->get('name');
        $category->save();

        return redirect()->route('admin.categories.index', [
            'parent' => $category->parent_id,
        ])->with(['success' => $message]);
    }

    /**
     * @throws ValidationException
     */
    public function changeStatus(Request $request, Category $category): RedirectResponse
    {
        $this->validate($request, [
            'status' => 'required|in:'.implode(',', array_keys(Category::STATUSES)),
        ]);

        if ($request->get('status') == Category::STATUS_ACTIVE) {
            if (Category::whereNull('parent_id')->whereStatus(Category::STATUS_ACTIVE)->count() >= 8) {
                return redirect()->back()->with(['error' => 'you can not add more than 8 category as parent']);
            }
        }

        $category->update([
            'status' => $request->get('status'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with(['success' => 'Categories updated successfully']);
    }

    public function subCategory(Request $request): array|Collection
    {
        return Category::whereParentId($request->get('parent_id'))
            ->where('status', Category::STATUS_ACTIVE)
            ->get();
    }

    /**
     * @throws Throwable
     */
    public function statusUpdate(Request $request): RedirectResponse
    {
        $checkCategory = Category::whereIn('id', $request->get('category'))->first();
        if ($checkCategory->parent_id != null) {
            $message = 'Sub Category status changed successfully';
        } else {
            $message = 'Category status changed successfully';
        }

        if ($request->get('changeStatus')) {
            if (count($request->get('category')) > 0) {
                DB::transaction(function () use ($request) {
                    Category::whereIn('id', $request->get('category'))
                        ->update(['status' => $request->get('changeStatus')]);
                });

                return redirect()->back()->with(['success' => $message]);
            }

            return redirect()->back()->with(['error' => 'Please select Category']);
        }

        return redirect()->back()->with(['error' => 'Please select status']);
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            if (Product::whereCategoryId($category->id)->exists()) {
                return redirect()->back()->with(['error' => 'This category is used in one or more Products']);
            }

            if (Category::whereParentId($category->id)->exists()) {
                return redirect()->back()->with(['error' => 'This category is used in one or more child Categories']);
            }

            $category->delete();

            return redirect()->back()->with(['success' => 'Category deleted successfully']);
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again']);
        }
    }
}
