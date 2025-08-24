<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\RewardBonus;
use App\Models\RewardBonusIncome;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class CalculateRewardBonusIncome implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Member $member;

    /**
     * Create a new job instance.
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $sponsor = Member::lockForUpdate()->find($this->member->sponsor_id);
            RewardBonus::each(function (RewardBonus $rewardBonus) use (&$sponsor) {
                if ($sponsor) {
                    RewardBonus::when($sponsor->reward_bonus_id, function ($query) use ($sponsor) {
                        return $query->where('id', '>', $sponsor->reward_bonus_id);
                    })->whereDoesntHave('rewardBonusIncome', function ($query) use ($sponsor) {
                        return $query->where('member_id', $sponsor->id);
                    })
                        ->eachById(function (RewardBonus $rewardBonus) use ($sponsor) {

                            $activeMember = Member::whereLevel($sponsor->level + $rewardBonus->level)
                                ->whereNotNull('package_id')
                                ->where('sponsor_path', 'like', $sponsor->sponsor_path.'/%')
                                ->count();

                            if ($activeMember >= $rewardBonus->target_active_member) {

                                $status = RewardBonusIncome::STATUS_ACHIEVED;
                                if ($sponsor->status != Member::STATUS_ACTIVE) {
                                    $status = RewardBonusIncome::STATUS_FLUSHED;
                                }

                                RewardBonusIncome::create([
                                    'reward_bonus_id' => $rewardBonus->id,
                                    'member_id' => $sponsor->id,
                                    'reward' => $rewardBonus->reward,
                                    'status' => $status,
                                ]);

                                $sponsor->update([
                                    'reward_bonus_id' => $rewardBonus->id,
                                ]);

                                return true;
                            } else {
                                return false;
                            }
                        });
                    $sponsor = $sponsor->sponsor;
                }
            });
        });
    }
}
