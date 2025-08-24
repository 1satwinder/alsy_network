<?php

namespace App\Observers;

use App\Models\FundWalletTransaction;

class FundWalletTransactionObserver
{
    /**
     * Handle the wallet transaction "created" event.
     *
     * @return void
     */
    public function created(FundWalletTransaction $fundWalletTransaction)
    {
        if ($fundWalletTransaction->type == FundWalletTransaction::TYPE_CREDIT) {
            $fundWalletTransaction->member->increment('fund_wallet_balance', $fundWalletTransaction->total);
        } elseif ($fundWalletTransaction->type == FundWalletTransaction::TYPE_DEBIT) {
            $fundWalletTransaction->member->decrement('fund_wallet_balance', $fundWalletTransaction->total);
        }
    }

    /**
     * Handle the wallet transaction "updated" event.
     *
     * @return void
     */
    public function updated(FundWalletTransaction $fundWalletTransaction)
    {
        //
    }

    /**
     * Handle the wallet transaction "deleted" event.
     *
     * @return void
     */
    public function deleted(FundWalletTransaction $fundWalletTransaction)
    {
        //
    }

    /**
     * Handle the wallet transaction "restored" event.
     *
     * @return void
     */
    public function restored(FundWalletTransaction $fundWalletTransaction)
    {
        //
    }

    /**
     * Handle the wallet transaction "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(FundWalletTransaction $fundWalletTransaction)
    {
        //
    }
}
