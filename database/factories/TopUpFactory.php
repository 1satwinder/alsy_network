<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Package;
use App\Models\Pin;
use App\Models\TopUp;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopUpFactory extends Factory
{
    protected $model = TopUp::class;

    public function definition(): array
    {
        return [
            'member_id' => function () {
                if (! $member = Member::whereNull('package_id')->first()) {
                    $member = Member::factory()->create();
                }

                return $member->id;
            },
            'package_id' => function () {
                if (! $package = Package::inRandomOrder()->first()) {
                    $package = Package::factory()->create();
                }

                return $package->id;
            },
            'pin_id' => function ($topUp) {
                if (! $pin = Pin::whereStatus(Pin::STATUS_UN_USED)
                    ->wherePackageId($topUp['package_id'])
                    ->whereMember($topUp['member_id'])
                    ->first()
                ) {
                    $pin = Pin::factory()->create([
                        'package_id' => $topUp['package_id'],
                        'member_id' => $topUp['member_id'],
                    ]);
                }

                return $pin->id;
            },
            'topped_up_by' => function ($topUp) {
                return $topUp['member_id'];
            },
        ];
    }
}
