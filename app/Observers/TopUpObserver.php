<?php

namespace App\Observers;

use App\Models\City;
use App\Models\InvoiceAddress;
use App\Models\Member;
use App\Models\PackageProduct;
use App\Models\State;
use App\Models\TopUp;
use App\Models\TopUpPackageProduct;

class TopUpObserver
{
    public function created(TopUp $topUp)
    {
        if ($topUp->member->topUps()->count() === 1) {
            $topUp->member->update([
                'activated_at' => $topUp->created_at,
                'is_paid' => Member::IS_PAID,
            ]);
        }

        $stateFlag = false;
        if ($topUp->member->user->state_id == settings('state_id')) {
            $stateFlag = true;
        }

        $totalSgstAmount = 0;
        $totalCgstAmount = 0;
        $totalIgstAmount = 0;
        $totalGstAmount = 0;

        foreach ($topUp->package->products as $product) {
            $percent = PackageProduct::GST_SLABS[$product->gst_slab];
            $sgstPercentage = 0;
            $cgstPercentage = 0;
            $igstPercentage = 0;
            $sgstAmount = 0;
            $cgstAmount = 0;
            $igstAmount = 0;

            if ($stateFlag) {
                $sgstPercentage = $percent / 2;
                $cgstPercentage = $percent / 2;
                $gstPercentage = $sgstPercentage + $cgstPercentage;
                $taxableValue = $product->price * 100 / (100 + ($gstPercentage));
                $sgstAmount = $taxableValue * $sgstPercentage / 100;
                $cgstAmount = $taxableValue * $cgstPercentage / 100;
                $gstAmount = $sgstAmount + $cgstAmount;
            } else {
                $igstPercentage = $percent;
                $gstPercentage = $igstPercentage;
                $taxableValue = $product->price * 100 / (100 + $gstPercentage);
                $igstAmount = $taxableValue * $igstPercentage / 100;
                $gstAmount = $igstAmount;
            }

            TopUpPackageProduct::create([
                'top_up_id' => $topUp->id,
                'package_id' => $topUp->package_id,
                'package_product_id' => $product->id,
                'name' => $product->name,
                'amount' => $product->price - $gstAmount,
                'total_gst_amount' => $gstAmount,
                'price' => $product->price,
                'hsn_code' => $product->hsn_code,
                'gst_slab' => $product->gst_slab,
                'sgst_percentage' => $sgstPercentage,
                'cgst_percentage' => $cgstPercentage,
                'igst_percentage' => $igstPercentage,
                'gst_percentage' => $percent,
                'sgst_amount' => $sgstAmount,
                'cgst_amount' => $cgstAmount,
                'igst_amount' => $igstAmount,
            ]);
            $totalSgstAmount += $sgstAmount;
            $totalCgstAmount += $cgstAmount;
            $totalIgstAmount += $igstAmount;
            $totalGstAmount += $gstAmount;
        }

        InvoiceAddress::create([
            'top_up_id' => $topUp->id,
            'member_id' => $topUp->member->id,
            'name' => $topUp->member->user->name,
            'country_id' => $topUp->member->user->country_id,
            'state_id' => $topUp->member->user->state_id,
            'city_id' => $topUp->member->user->city_id,
            'member_address' => $topUp->member->user->address,
            'member_email' => $topUp->member->user->email,
            'member_mobile' => $topUp->member->user->mobile,
            'member_pincode' => $topUp->member->user->pincode,
            'admin_address' => settings('address_line_1'),
            'admin_city' => City::whereName('Vadodara')->first()?->name,
            'admin_state' => State::whereName('Gujarat')->first()?->name,
            'admin_pincode' => settings('pincode') ?? null,
            'admin_mobile' => settings('mobile') ?? null,
            'admin_email' => settings('mobile') ?? null,
        ]);

        $topUp->invoice_no = str_pad($topUp->id, 3, '0', STR_PAD_LEFT);
        $topUp->gst_amount = $topUp->package->products->sum('gst_amount');
        $topUp->sgst_amount = $totalSgstAmount;
        $topUp->cgst_amount = $totalCgstAmount;
        $topUp->igst_amount = $totalIgstAmount;
        $topUp->package_amount = $topUp->amount - $totalGstAmount;
        $topUp->gst_amount = $totalGstAmount;

        $topUp->save();
    }
}
