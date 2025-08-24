<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PinRequest;
use DB;
use Illuminate\Http\RedirectResponse;
use Throwable;

class RejectPinRequestController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function store(PinRequest $pinRequest)
    {
        try {
            return DB::transaction(function () use ($pinRequest) {
                if (! $pinRequest->isPending()) {
                    return redirect()->back()->with('error', 'Pin Request already approved or rejected');
                }

                $pinRequest->update([
                    'status' => PinRequest::STATUS_REJECTED,
                ]);

                return redirect()->back()->with('success', 'Pin Request rejected successfully');
            });
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again later');
        }
    }
}
