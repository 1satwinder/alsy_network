<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Session;

class CartController extends Controller
{
    public function index()
    {
        if (! $cartItems = Session::get('cart')) {
            $cart = [];
            Session::put('cart', $cart);
        }

        $cartItems = Session::get('cart');
        $cartProducts = Product::with('media')->find(array_keys($cartItems));
        $cartTotal = 0;
        $cartShippingTotal = 0;
        $cartProducts->map(function (Product $product) use ($cartItems, &$cartTotal, &$cartShippingTotal) {
            $product->quantity = $cartItems[$product->id];
            $product->subTotal = round(($product->dp * $product->quantity), 2);
            $product->imageUrl = $product->getFirstMediaUrl(Product::MC_PRODUCT_IMAGE);
            $cartTotal += round($product->subTotal, 2);
            $cartShippingTotal += round($product->shipping_charge, 2);

            return $product;
        });
        $transports = ['By Hand', 'Courier', 'Transport'];

        return view('website.product.cart.index',
            [

                'cartProducts' => $cartProducts,
                'cartTotal' => $cartTotal,
                'cartShippingTotal' => $cartShippingTotal,
                'states' => State::get(),

            ]
        );
    }

    /**
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:1',
        ]);

        $productId = $request->get('product_id');
        $quantity = (int) $request->get('quantity');

        if (! $cart = Session::get('cart')) {
            $cart = [];
        }

        if (isset($cart[$productId])) {
            if ($request->get('status') == 2) {
                $cart[$productId] -= $quantity;
            } else {
                $cart[$productId] += $quantity;
            }
        } else {
            $cart[$productId] = $quantity;
        }
        if ($product = Product::find($productId)) {
            if ($product->company_stock < $cart[$productId]) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product cannot added to cart because only '.round($product->company_stock).' products available',
                ]);
            }
        }
        Session::put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart',
            'cartCount' => count($cart),
        ]);
    }

    public function deliveredType(Request $request)
    {
        $shippingCharge = 0;
        if ($request->type == 1) {
            $shippingCharge = Product::find($request->product_id)->shipping_charge;
        }

        return response()->json([
            'shippingCharge' => $shippingCharge,
        ]);
    }

    /**
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = Session::get('cart');

        unset($cart[$request->get('product_id')]);

        Session::put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Product removed from cart',
            'cartCount' => count($cart),
        ]);
    }

    public function thanks()
    {
        return view('website.product.cart.thanks');
    }
}
