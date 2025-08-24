<?php

namespace App\Observers;

use App\Models\KYC;

class KYCObserver
{
    public function saving(KYC $kyc)
    {
        if ($kyc->status != $kyc->getOriginal('status')) {
            if ($kyc->isPending()) {
                $kyc->applied_at = now();
            } elseif ($kyc->isApproved()) {
                $kyc->approved_at = now();
            } elseif ($kyc->isRejected()) {
                $kyc->rejected_at = now();
            }
        }
    }
}
