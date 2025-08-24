<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\OrderRequest;
use App\Models\Product;
use App\Models\State;
use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Session;

class CartController extends Controller
{
    public function index(): Renderable
    {
        $details = Cart::getDetail($this->member);
        $cartProducts = [];
        if ($details) {
            if (count($details->products) > 0) {
                $cartProducts = $details->products;
            }
        }

        return view('website.'.settings('front_template').'.website.cart.index',
            [
                'cartProducts' => $cartProducts,
                'cartDetail' => $details,
                'states' => State::get(),
                'member' => $this->member,
            ]
        );
    }

    public function update(Request $request): JsonResponse
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:1',
        ]);

        $productId = $request->get('product_id');
        $quantity = (int) $request->get('quantity');
        $product = Product::with('media')->find($productId);
        if (! Auth::user()) {
            Session::put('getProduct', $product);

            return response()->json([
                'status' => 404,
                'url' => route('member.login.create'),
            ]);
        }

        $cart = Cart::whereMemberId($this->member->id)->first();
        if ($cart) {
            $carts = json_decode($cart->details);
            if ($carts != null) {
                foreach ($carts as $test) {
                    if ($product->id == $test->product_id) {
                        if ($product->company_stock < $quantity) {
                            if ($product->company_stock < $test->selected_qty + $quantity) {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Only '.round($product->company_stock).' product available',
                                ]);
                            }
                        }
                    }
                }
            }
        }

        $productArray = Cart::addToCart($this->member, $productId, $quantity);

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart',
            'cartCount' => count($productArray),
        ]);
    }

    public function payment()
    {
        if (! $cartItems = Session::get('cart')) {
            $cart = [];
            Session::put('cart', $cart);
        }

        $cartItems = Session::get('cart');
        $cartProducts = Product::with('media', 'GSTType')->find(array_keys($cartItems));
        $cartTotal = 0;
        $cartGSTTotal = 0;
        $cartProducts->map(function (Product $product) use (&$cartGSTTotal, $cartItems, &$cartTotal) {
            $product->quantity = $cartItems[$product->id];
            $product->subTotal = round(($product->dp * $product->quantity), 2);
            $product->imageUrl = $product->getFirstMediaUrl(Product::MC_PRODUCT_IMAGE);
            $cartTotal += round($product->subTotal, 2);

            return $product;
        });
        if ($cartTotal + $cartGSTTotal < 500) {
            $cartShippingTotal = 60;
        } else {
            $cartShippingTotal = 0;
        }

        return view('website.'.settings('front_template').'.website.cart.thanks',
            [
                'cartProducts' => $cartProducts,
                'cartTotal' => $cartTotal,
                'cartShippingTotal' => $cartShippingTotal,
                'cartGSTTotal' => $cartGSTTotal,
                'states' => State::get(),
                'paymentModes' => OrderRequest::PAYMENT_MODES,
            ]
        );
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

        $cart = Cart::where('member_id', $this->member->id)->first();

        $productId = $request->get('product_id');
        if ($cart) {
            $products = json_decode($cart->details, true);
            $productArray = collect($products)->filter(function ($product) use ($productId) {
                return $product['product_id'] != $productId;
            })->values();

            Cart::where('member_id', $this->member->id)->update([
                'details' => json_encode($productArray),
            ]);

            return response()->json(['status' => true, 'message' => 'Product removed successfully', 'cartCount' => count($productArray)]);
        }

        return response()->json(['status' => false, 'message' => 'cart not exist for this member']);
    }
}
