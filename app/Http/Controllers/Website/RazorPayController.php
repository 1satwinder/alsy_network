<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class RazorPayController extends Controller
{
    public function index(Request $request, Order $order)
    {
        $this->validate($request, [
            'transaction_id' => 'required',
        ]);

        if ($order) {
            $order->updateAndProcessPaymentStatus(
                $request->get('transaction_id')
            );

            return redirect()->route('website.orders.thanks', ['order' => $order])->with('success', 'Product Purchased successfully.');
        }

        return redirect()->route('website.home')->with(['error' => 'invalid order details']);

    }
}
