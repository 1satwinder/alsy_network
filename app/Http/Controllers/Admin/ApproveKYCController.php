<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KYC;
use DB;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ApproveKYCController extends Controller
{
    public function store(KYC $kyc): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($kyc) {
                if (! $kyc->isPending()) {
                    return redirect()->back()->with('error', 'KYC is already approved or rejected');
                }

                if ($kyc->pan_card !== 'ABBCA0900E') {
                    if (
                        KYC::wherePanCard($kyc->pan_card)
                            ->whereNotNull('pan_card')
                            ->where('status', '!=', KYC::STATUS_REJECTED)
                            ->where('member_id', '!=', $kyc->member_id)
                            ->count() >= 3
                    ) {
                        return redirect()->back()->with('error', 'The same PAN card number can only be used by three members for kyc')->withInput();
                    }
                }

                $kyc->status = KYC::STATUS_APPROVED;
                $kyc->save();

                return redirect()->back()
                    ->with('success', 'KYC approved successfully');
            });

        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }
}
