<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Share;

class ProductController extends Controller
{
    public function index($categoryPrefix = null): Renderable
    {
        $category = Category::where('prefix', $categoryPrefix)->first();

        $productsQuery = Product::with('media', 'category')
            ->orderBy('id', 'desc')
            ->where('status', Product::STATUS_ACTIVE)
            ->when($category, function (Builder $query) use ($category) {
                return $query->where('category_id', $category->id);
            });

        $sideCategories = Category::whereStatus(Category::STATUS_ACTIVE)
            ->with('children')
            ->when($category, function (Builder $query) use ($category) {
                return $query->where('parent_id', $category->parent_id);
            })
            ->get();

        /** @var LengthAwarePaginator $productPaginator */
        $productPaginator = $productsQuery->paginate(16);

        return view('member.product.index', [
            'products' => $productPaginator,
            'total' => $productPaginator->total(),
            'category' => $category,
            'auth' => Auth::check() && Auth::user()->hasRole('member'),
            'categories' => Category::whereStatus(Category::STATUS_ACTIVE)->with('children')->whereNull('parent_id')->get(),
            'sideCategories' => $sideCategories,
        ]);
    }

    public function detail(Product $product)
    {
        return view('member.product.detail', [
            'product' => $product,
            'socialMediaLinks' => Share::page(route('website.product.detail', $product), $product->name, ['class' => 'social-link', 'title' => 'Product Share'])
                ->facebook()
                ->whatsapp(),
        ]);
    }
}
