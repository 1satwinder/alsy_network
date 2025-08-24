<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\TeamBonus;
use App\Models\TeamBonusIncome;
use App\Models\TopUp;
use App\Models\WalletTransaction;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateTeamBonusIncome implements ShouldQueue
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
            $sponsor = $this->topUp->member?->sponsor?->sponsor;
            TeamBonus::where('id', '>', 1)
                ->eachById(function (TeamBonus $teamBonus) use (&$sponsor) {
                    if (! $sponsor) {
                        return false;
                    }

                    $amount = $this->topUp->package->pv * $teamBonus->income_percent / 100;
                    $comment = 'Team Bonus Income for level '.$teamBonus->level.' from '.$this->topUp->member->user->name.'('.$this->topUp->member->code.')';

                    if (Member::where('sponsor_id', $sponsor->id)
                        ->where('is_paid', Member::IS_PAID)
                        ->count() < $teamBonus->direct) {
                        $amount = 0;
                        $comment .= ' flushed due to direct condition unfulfillment';
                    } else {
                        if ($sponsor->status != Member::STATUS_ACTIVE) {
                            $amount = 0;

                            if ($sponsor->status == Member::STATUS_FREE_MEMBER) {
                                $comment .= ' flushed as member free';
                            }

                            if ($sponsor->status == Member::STATUS_BLOCKED) {
                                $comment .= ' flushed as member was blocked';
                            }
                        }
                    }

                    $referralBonusIncome = TeamBonusIncome::create([
                        'team_bonus_id' => $teamBonus->id,
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

                    $sponsor = $sponsor->sponsor;

                    return true;
                });
        });
    }
}
