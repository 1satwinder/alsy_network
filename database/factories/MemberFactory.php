<?php

namespace Database\Factories;

use App\Jobs\AddMemberOnPool;
use App\Jobs\CalculateReferralBonusIncome;
use App\Jobs\CalculateRewardBonusIncome;
use App\Jobs\CalculateTeamBonusIncome;
use App\Models\MagicPool;
use App\Models\Member;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'sponsor_id' => function () {
                if ($sponsor = Member::inRandomOrder()->first()) {
                    return $sponsor->id;
                }

                return null;
            },

            'level' => function ($member) {
                if ($sponsor = Member::find($member['sponsor_id'])) {
                    return $sponsor->level + 1;
                }

                return 1;
            },
            'status' => function () {
                $statusChance = mt_rand(0, 99);
                if ($statusChance < 80) {
                    return Member::STATUS_ACTIVE;
                } elseif ($statusChance < 95) {
                    return Member::STATUS_FREE_MEMBER;
                } else {
                    return Member::STATUS_BLOCKED;
                }
            },
            'package_id' => function ($member) {
                if ($member['status'] == Member::STATUS_ACTIVE) {
                    if ($package = Package::inRandomOrder()->first()) {
                        return $package->id;
                    }
                }

                return null;
            },
        ];
    }

    public function configure(): MemberFactory
    {
        return $this->afterCreating(function (Member $member) {
            $member->user->assignRole('member');

            if ($member->status == Member::STATUS_FREE_MEMBER) {
                $member->status = Member::STATUS_ACTIVE;
            }
            $package = Package::first();
            $member->save();

            $topup = $member->topUps()->create([
                'package_id' => $package->id,
                'amount' => $package->amount,
                'topped_up_by' => $member->id,
            ]);

            if ($member->sponsor) {
                CalculateReferralBonusIncome::dispatch($topup);
                CalculateTeamBonusIncome::dispatch($topup);
            }
            CalculateRewardBonusIncome::dispatch($topup->member);
            AddMemberOnPool::dispatch($topup->member, MagicPool::first());
        });
    }
}
