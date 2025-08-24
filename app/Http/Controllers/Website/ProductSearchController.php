<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function getProductSuggestion(Request $request)
    {
        return Product::where('name', 'like', '%'.$request->term.'%')
            ->where('status', Product::STATUS_ACTIVE)
            ->select('name as value', 'name as label', 'slug as slug')
            ->take(5)->get();
    }

    public function searchProduct(Request $request): RedirectResponse
    {
        if ($request->searchProduct == null) {
            return redirect()->route('website.home');
        }

        if ($product = Product::where('slug', $request->searchProduct)->where('status', Product::STATUS_ACTIVE)->first()) {
            if ($product->name != $request->searchProduct) {
                $product = Product::where('name', 'like', '%'.$request->searchProduct.'%')->first();

                return redirect()->route('website.product.detail', ['product' => $product->name]);
            } else {
                return redirect()->route('website.product.detail', ['product' => $product->slug]);
            }
        } elseif ($product = Product::where('name', 'like', '%'.$request->searchProduct.'%')->first()) {
            return redirect()->route('website.product.detail', ['product' => $product->slug]);
        } else {
            return redirect()->route('website.home');
        }
    }
}
