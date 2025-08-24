<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Pagination\LengthAwarePaginator;
use Share;

class ProductController extends Controller
{
    public function index($categoryPrefix): Renderable
    {
        $category = Category::where('prefix', $categoryPrefix)->first();
        $sideCategories = [];
        if ($category) {
            $productsQuery = Product::with('media', 'category')
                ->orderBy('id', 'desc')
                ->where('status', Product::STATUS_ACTIVE)
                ->where('category_id', $category->id);

            $sideCategories = Category::whereStatus(Category::STATUS_ACTIVE)
                ->with('children')
                ->where('parent_id', $category->parent_id)
                ->get();
        } else {
            $productsQuery = Product::with('media', 'category')
                ->orderBy('id', 'desc')
                ->where('status', Product::STATUS_ACTIVE);
        }

        /** @var LengthAwarePaginator $productPaginator */
        $productPaginator = $productsQuery->paginate();

        return view('website.product.index', [
            'products' => $productPaginator,
            'total' => $productPaginator->total(),
            'category' => $category,
            'auth' => Auth::check() && Auth::user()->hasRole('member'),
            'categories' => Category::whereStatus(Category::STATUS_ACTIVE)->with('children')->whereNull('parent_id')->get(),
            'sideCategories' => $sideCategories,
        ]);
    }

    public function detail(Product $product): Renderable
    {
        $relatedProductsQuery = Product::with('media')
            ->where('status', Product::STATUS_ACTIVE)
            ->where('category_id', $product->category_id)
            ->limit(8)
            ->get();

        return view('website.product.detail', [
            'relatedProducts' => $relatedProductsQuery,
            'product' => $product,
            'socialMediaLinks' => Share::page(route('website.product.detail', $product), $product->name, ['class' => 'social-link', 'title' => 'Product Share'])
                ->facebook()
                ->whatsapp(),
        ]);
    }
}
