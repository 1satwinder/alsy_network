<?php

namespace Database\Seeders;

use App\Models\MagicPool;
use DB;
use Illuminate\Database\Seeder;

class MagicPoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            collect([
                [
                    'name' => 'Magic Pool 1',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 800,
                    'upgrade_amount' => 400,
                    'net_income' => 400,
                ],
                [
                    'name' => 'Magic Pool 2',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 1600,
                    'upgrade_amount' => 800,
                    'net_income' => 800,
                ],
                [
                    'name' => 'Magic Pool 3',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 3200,
                    'upgrade_amount' => 2000,
                    'net_income' => 1200,
                ],
                [
                    'name' => 'Magic Pool 4',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 8000,
                    'upgrade_amount' => 4000,
                    'net_income' => 4000,
                ],
                [
                    'name' => 'Magic Pool 5',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 16000,
                    'upgrade_amount' => 8000,
                    'net_income' => 8000,
                ],
                [
                    'name' => 'Magic Pool 6',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 32000,
                    'upgrade_amount' => 16000,
                    'net_income' => 16000,
                ],
                [
                    'name' => 'Magic Pool 7',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 64000,
                    'upgrade_amount' => 32000,
                    'net_income' => 32000,
                ],
                [
                    'name' => 'Magic Pool 8',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 128000,
                    'upgrade_amount' => 64000,
                    'net_income' => 64000,
                ],
                [
                    'name' => 'Magic Pool 9',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 256000,
                    'upgrade_amount' => 156000,
                    'net_income' => 100000,
                ],
                [
                    'name' => 'Magic Pool 10',
                    'level' => 1,
                    'total_member' => 4,
                    'total_income' => 624000,
                    'upgrade_amount' => 0,
                    'net_income' => 624000,
                ],
            ])->each(function ($pool) {
                MagicPool::create([
                    'name' => $pool['name'],
                    'level' => $pool['level'],
                    'total_member' => $pool['total_member'],
                    'total_income' => $pool['total_income'],
                    'upgrade_amount' => $pool['upgrade_amount'],
                    'net_income' => $pool['net_income'],
                ]);
            });
        });

    }
}
