<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\TopUp;
use App\Models\TopUpPackageProduct;
use Illuminate\Http\Response;
use Image;
use PDF;

class InvoiceController extends Controller
{
    public function show(TopUp $topUp): Response
    {
        $logo = Image::make(
            settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png')))
        )->encode('data-url')->__toString();

        $products = $topUp->topUpPackageProducts->map(function (TopUpPackageProduct $topUpPackageProduct) {
            $gstAmount = $topUpPackageProduct->total_gst_amount;

            return [
                'name' => $topUpPackageProduct->name,
                'hsn_code' => $topUpPackageProduct->hsn_code,
                'price' => $topUpPackageProduct->price - $gstAmount,
                'gst_amount' => $gstAmount,
                'gst_percent' => $topUpPackageProduct->present()->gstSlab(),
                'gst_slab' => $topUpPackageProduct->gst_slab,
                'sgst_percentage' => $topUpPackageProduct->sgst_percentage,
                'cgst_percentage' => $topUpPackageProduct->cgst_percentage,
                'igst_percentage' => $topUpPackageProduct->igst_percentage,
                'gst_percentage' => $topUpPackageProduct->gst_percentage,
                'sgst_amount' => $topUpPackageProduct->sgst_amount,
                'cgst_amount' => $topUpPackageProduct->cgst_amount,
                'igst_amount' => $topUpPackageProduct->igst_amount,
                'total' => $topUpPackageProduct->price,
            ];
        });

        $pdf = PDF::loadView('member.invoice.topup-invoice-html', [
            'member' => $topUp->member,
            'products' => $products,
            'logo' => $logo,
            'topUp' => $topUp,
        ]);

        return $pdf->stream("Invoice-{$topUp->member->code}.pdf")->header('X-Vapor-Base64-Encode', 'True');

    }

    public function orderInvoice(Order $order): Response
    {
        $logo = Image::make(
            settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png')))
        )->encode('data-url')->__toString();

        $products = $order->products()->with('product.GSTType')->get()->map(function (OrderProduct $orderProduct) {
            $gstAmount = $orderProduct->gst_amount;

            return [
                'name' => $orderProduct->product->name,
                'price' => $orderProduct->product->mrp - $gstAmount,
                'gst_amount' => $gstAmount,
                //                'gst_percent' => $orderProduct->product->GSTType->hsn_code,
                'total' => $orderProduct->amount,
            ];
        });

        $amountInWords = currencyInWords($order->total);

        $pdf = PDF::loadView('order-invoice', [
            'member' => $order->member,
            'products' => $products,
            'invoice' => $order,
            'amountInWords' => $amountInWords,
            'logo' => $logo,
        ]);

        return $pdf->stream("{$order->order_no}.pdf")->header('X-Vapor-Base64-Encode', 'True');
    }
}
