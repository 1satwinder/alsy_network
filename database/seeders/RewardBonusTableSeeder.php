<?php

namespace Database\Seeders;

use App\Models\RewardBonus;
use DB;
use Illuminate\Database\Seeder;
use Throwable;

class RewardBonusTableSeeder extends Seeder
{
    /**
     * @throws Throwable
     */
    public function run(): void
    {
        DB::transaction(function () {
            collect([
                [
                    'level' => 1,
                    'target_active_member' => 5,
                    'reward' => 'Reward 1',
                ],
                [
                    'level' => 2,
                    'target_active_member' => 25,
                    'reward' => 'Reward 2',
                ],
                [
                    'level' => 3,
                    'target_active_member' => 125,
                    'reward' => 'Reward 3',
                ],
                [
                    'level' => 4,
                    'target_active_member' => 625,
                    'reward' => 'Reward 4',
                ],
                [
                    'level' => 5,
                    'target_active_member' => 3125,
                    'reward' => 'Reward 5',
                ],
                [
                    'level' => 6,
                    'target_active_member' => 15625,
                    'reward' => 'Reward 6',
                ],
                [
                    'level' => 7,
                    'target_active_member' => 78125,
                    'reward' => 'Reward 7',
                ],
                [
                    'level' => 8,
                    'target_active_member' => 390625,
                    'reward' => 'Reward 8',
                ],
            ])->each(fn ($bonus) => RewardBonus::updateOrCreate([
                'level' => $bonus['level'],
            ], [
                'target_active_member' => $bonus['target_active_member'],
                'reward' => $bonus['reward'],
            ]));
        });
    }
}
