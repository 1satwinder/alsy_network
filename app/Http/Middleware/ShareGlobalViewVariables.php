<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\Category;
use App\Models\WebSetting;
use Auth;
use Closure;
use View;

class ShareGlobalViewVariables
{
    public function handle($request, Closure $next): mixed
    {
        //        View::share('webSettings', WebSetting::firstOrNew([]));

        $cart = 0;
        if (Auth::guard('member')->check()) {
            $details = Cart::getDetail(Auth::guard('member')->user()->member);
            $cart = count($details->products);
        }
        View::share('cart', $cart);

        View::share(
            'categories',
            Category::with([
                'children' => function ($query) {
                    return $query->where('status', Category::STATUS_ACTIVE);
                },
                'children.children' => function ($query) {
                    return $query->where('status', Category::STATUS_ACTIVE);
                },
            ])->where('status', Category::STATUS_ACTIVE)
                ->whereNull('parent_id')->get()
        );

        return $next($request);
    }
}
