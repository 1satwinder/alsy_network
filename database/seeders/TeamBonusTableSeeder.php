<?php

namespace Database\Seeders;

use App\Models\TeamBonus;
use DB;
use Illuminate\Database\Seeder;

class TeamBonusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            collect([
                [
                    'level' => 1,
                    'direct' => 0,
                    'income_percent' => 0,
                ], [
                    'level' => 2,
                    'direct' => 1,
                    'income_percent' => 10,
                ], [
                    'level' => 3,
                    'direct' => 2,
                    'income_percent' => 10,
                ], [
                    'level' => 4,
                    'direct' => 2,
                    'income_percent' => 7,
                ], [
                    'level' => 5,
                    'direct' => 3,
                    'income_percent' => 4,
                ], [
                    'level' => 6,
                    'direct' => 3,
                    'income_percent' => 4,
                ], [
                    'level' => 7,
                    'direct' => 4,
                    'income_percent' => 3,
                ], [
                    'level' => 8,
                    'direct' => 5,
                    'income_percent' => 2,
                ],
            ])->each(function ($teamBonus) {
                TeamBonus::updateOrCreate([
                    'level' => $teamBonus['level'],
                ], [
                    'direct' => $teamBonus['direct'],
                    'income_percent' => $teamBonus['income_percent'],
                ]);
            });
        });
    }
}
