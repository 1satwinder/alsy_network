<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\ReferralBonusIncome;
use App\Models\TopUp;
use App\Models\WalletTransaction;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateReferralBonusIncome implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TopUp $topUp;

    /**
     * Create a new job instance.
     */
    public function __construct(TopUp $topUp)
    {
        $this->topUp = $topUp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $sponsor = $this->topUp->member->sponsor;
            if ($sponsor) {
                $amount = $this->topUp->package->pv * $this->topUp->package->referral_bonus_per / 100;
                $comment = 'Referral Bonus Income from '.$this->topUp->member->user->name.'('.$this->topUp->member->code.')';
                if ($sponsor->status != Member::STATUS_ACTIVE) {
                    $amount = 0;

                    if ($sponsor->status == Member::STATUS_FREE_MEMBER) {
                        $comment = 'Referral Bonus Income from '.$this->topUp->member->user->name.'('.$this->topUp->member->code.') flushed as member free';

                    }

                    if ($sponsor->status == Member::STATUS_BLOCKED) {
                        $comment = 'Referral Bonus Income from '.$this->topUp->member->user->name.'('.$this->topUp->member->code.') flushed as member was blocked';
                    }
                }
                $referralBonusIncome = ReferralBonusIncome::create([
                    'top_up_id' => $this->topUp->id,
                    'member_id' => $sponsor->id,
                    'from_member_id' => $this->topUp->member_id,
                    'total' => $amount,
                ]);

                $referralBonusIncome->walletTransaction()->create([
                    'member_id' => $sponsor->id,
                    'opening_balance' => $sponsor->wallet_balance,
                    'closing_balance' => $sponsor->wallet_balance + $amount,
                    'amount' => $amount,
                    'tds' => 0,
                    'admin_charge' => 0,
                    'total' => $amount,
                    'type' => WalletTransaction::TYPE_CREDIT,
                    'comment' => $comment,
                ]);
            }
        });
    }
}
