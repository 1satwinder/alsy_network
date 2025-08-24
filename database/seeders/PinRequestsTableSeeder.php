<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\PinRequest;
use DB;
use Illuminate\Database\Seeder;
use Throwable;

class PinRequestsTableSeeder extends Seeder
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
            for ($i = 0; $i < 2; $i++) {
                PinRequest::factory()->create([
                    'member_id' => Member::first()->id,
                    'status' => PinRequest::STATUS_PENDING,
                ]);
            }

            for ($i = 0; $i < 2; $i++) {
                PinRequest::factory()->create([
                    'member_id' => Member::first()->id,
                    'status' => PinRequest::STATUS_APPROVED,
                ]);
            }

            PinRequest::factory()->create([
                'member_id' => Member::first()->id,
                'status' => PinRequest::STATUS_REJECTED,
            ]);
        });
    }
}
