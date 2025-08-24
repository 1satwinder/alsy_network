<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KYC;
use Illuminate\Http\Request;

class RejectKYCController extends Controller
{
    public function store(KYC $kyc, Request $request)
    {
        $this->validate($request, [
            'reason' => 'nullable',
        ]);

        if (! $kyc->isPending()) {
            return redirect()->back()->with('error', 'KYC is already approved or rejected');
        }

        $kyc->reason = $request->get('reason');
        $kyc->status = KYC::STATUS_REJECTED;
        $kyc->admin_id = $this->admin->id;
        $kyc->save();

        return redirect()->route('admin.kycs.index', 'pending')
            ->with('success', 'KYC rejected successfully');
    }
}
