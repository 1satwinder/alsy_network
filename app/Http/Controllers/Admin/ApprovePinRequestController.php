<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pin;
use App\Models\PinRequest;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Throwable;

class ApprovePinRequestController extends Controller
{
    public function store(PinRequest $pinRequest): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($pinRequest) {
                if (! $pinRequest->isPending()) {
                    return redirect()->back()->with('error', 'Pin Request already approved or rejected');
                }

                $pinRequest->update([
                    'status' => PinRequest::STATUS_APPROVED,
                ]);

                for ($i = 0; $i < $pinRequest->no_pins; $i++) {
                    Pin::create([
                        'pin_request_id' => $pinRequest->id,
                        'package_id' => $pinRequest->package_id,
                        'member_id' => $pinRequest->member_id,
                        'code' => strtoupper(Str::random(10)),
                        'amount' => $pinRequest->package->amount,
                        'status' => Pin::STATUS_UN_USED,
                    ]);
                }

                return redirect()->back()->with('success', 'Pin Request approved successfully.');
            });
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
