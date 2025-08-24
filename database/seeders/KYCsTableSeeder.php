<?php

namespace Database\Seeders;

use App\Models\KYC;
use DB;
use Illuminate\Database\Seeder;
use Throwable;

class KYCsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function run()
    {
        DB::transaction(function () {
            for ($i = 0; $i <= 2; $i++) {
                KYC::factory()->create([
                    'status' => KYC::STATUS_PENDING,
                ]);
            }

            KYC::factory()->create([
                'status' => KYC::STATUS_APPROVED,
            ]);

            KYC::factory()->create([
                'status' => KYC::STATUS_REJECTED,
            ]);
        });
    }
}
