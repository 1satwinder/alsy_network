<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\MagicPoolIncome;
use App\Models\MemberStat;
use App\Models\ReferralBonusIncome;
use App\Models\TeamBonusIncome;
use App\Models\WalletTransaction;

class WalletTransactionObserver
{
    /**
     * Handle the wallet transaction "created" event.
     *
     * @return void
     */
    public function created(WalletTransaction $walletTransaction)
    {
        if ($walletTransaction->type == WalletTransaction::TYPE_CREDIT) {
            $walletTransaction->member->increment('wallet_balance', $walletTransaction->total);

            if (MemberStat::whereMemberId($walletTransaction->member_id)->doesntExist()) {
                MemberStat::create([
                    'member_id' => $walletTransaction->member_id,
                ]);
            }

            MemberStat::whereMemberId($walletTransaction->member_id)->incrementEach([
                'all_income' => $walletTransaction->total,
                'referral_bonus_income' => $walletTransaction->responsible_type === ReferralBonusIncome::class
                    ? $walletTransaction->total :
                    0,
                'team_bonus_income' => $walletTransaction->responsible_type === TeamBonusIncome::class
                    ? $walletTransaction->total :
                    0,
                'magic_pool_bonus_income' => $walletTransaction->responsible_type === MagicPoolIncome::class
                    ? $walletTransaction->total :
                    0,
                'admin_credit' => $walletTransaction->responsible_type === Admin::class
                    ? $walletTransaction->total :
                    0,
            ]);
        } elseif ($walletTransaction->type == WalletTransaction::TYPE_DEBIT) {
            $walletTransaction->member->decrement('wallet_balance', $walletTransaction->total);
        }
    }

    /**
     * Handle the wallet transaction "updated" event.
     *
     * @return void
     */
    public function updated(WalletTransaction $walletTransaction)
    {
        //
    }

    /**
     * Handle the wallet transaction "deleted" event.
     *
     * @return void
     */
    public function deleted(WalletTransaction $walletTransaction)
    {
        //
    }

    /**
     * Handle the wallet transaction "restored" event.
     *
     * @return void
     */
    public function restored(WalletTransaction $walletTransaction)
    {
        //
    }

    /**
     * Handle the wallet transaction "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(WalletTransaction $walletTransaction)
    {
        //
    }
}
