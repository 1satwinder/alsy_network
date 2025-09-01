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
    // ... existing code ...
public function run(): void
{
    DB::transaction(function () {
        collect([
            [
                'level' => 1,
                'target_active_member' => 5,
                'reward' => 'Dinner Set',
            ],
            [
                'level' => 2,
                'target_active_member' => 25,
                'reward' => 'Business (PV) = (Induction)',
            ],
            [
                'level' => 3,
                'target_active_member' => 125,
                'reward' => 'Business (PV) = (RO Purifier Water)',
            ],
            [
                'level' => 4,
                'target_active_member' => 625,
                'reward' => 'Tablet (TAB)',
            ],
            [
                'level' => 5,
                'target_active_member' => 3125,
                'reward' => 'Foreign Trip',
            ],
            [
                'level' => 6,
                'target_active_member' => 15625,
                'reward' => 'Car Down Payment Support',
            ],
            [
                'level' => 7,
                'target_active_member' => 78125,
                'reward' => 'International Luxury Cruise Trip (Covering 5-10 Countries)',
            ],
            [
                'level' => 8,
                'target_active_member' => 390625,
                'reward' => 'Mercedes Car or (3500000₹ Cash)',
            ],
            [
                'level' => 9,
                'target_active_member' => 1953125,
                'reward' => 'Banglow / National Property (Worth ₹1.5 CR)',
            ],
            [
                'level' => 10,
                'target_active_member' => 9765625,
                'reward' => 'International Property (Worth ₹9 CR)',
            ],
        ])->each(fn ($bonus) => RewardBonus::updateOrCreate([
            'level' => $bonus['level'],
        ], [
            'target_active_member' => $bonus['target_active_member'],
            'reward' => $bonus['reward'],
        ]));
    });
}
// ... existing code ...
}
