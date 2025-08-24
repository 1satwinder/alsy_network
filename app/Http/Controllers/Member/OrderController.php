<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\ListBuilders\Member\OrderListBuilder;
use App\ListBuilders\Member\OrderProductListBuilder;
use App\Models\Order;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image;
use PDF;

class OrderController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Renderable|RedirectResponse|JsonResponse
    {
        return OrderListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    /**
     * @throws Exception
     */
    public function show(Request $request, Order $order): Renderable|RedirectResponse|JsonResponse
    {
        return OrderProductListBuilder::render([
            'order_id' => $order->id,
        ]);
    }

    public function invoiceDetails(Order $order): Response|RedirectResponse
    {
        if ($logo = settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png')))) {
            $logo = Image::make($logo)->encode('data-url')->__toString();
        } else {
            $logo = asset(env('LOGO', '/images/logo.png'));
        }

        if (! Order::whereMemberId($this->member->id)->whereId($order->id)->exists()) {
            return redirect()->back()->with(['error' => 'Invalid Invoice']);
        }

        $amountInWords = currencyInWords($order->total);

        $pdf = PDF::loadView('order-invoice', [
            'invoice' => $order,
            'amountInWords' => $amountInWords,
            'logo' => $logo,
        ]);

        return $pdf->stream("{$order->order_no}.pdf")->header('X-Vapor-Base64-Encode', 'True');
    }
}
