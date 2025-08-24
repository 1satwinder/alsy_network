<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageProduct;
use DB;
use Illuminate\Database\Seeder;
use Str;
use Throwable;

class PackageTableSeeder extends Seeder
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
            collect([
                [
                    'name' => 'Starter Package',
                    'referral_bonus_per' => 40,
                    'pv' => 1000,
                    'products' => [
                        [
                            'name' => 'Digital Education',
                            'price' => 1550,
                            'gst_slab' => PackageProduct::GST_SLAB_18,
                        ],
                    ],
                ],
            ])->each(function ($package) {
                $packageModel = Package::updateOrCreate([
                    'name' => $package['name'],
                ], [
                    'referral_bonus_per' => $package['referral_bonus_per'],
                    'pv' => $package['pv'],
                ]);

                $amount = 0;
                foreach ($package['products'] as $product) {
                    $packageModel->products()->updateOrCreate([
                        'name' => $product['name'],
                    ], [
                        'price' => $product['price'],
                        'gst_slab' => $product['gst_slab'],
                        'hsn_code' => Str::random(4),
                    ]);

                    $amount += $product['price'];
                }

                $packageModel->update([
                    'amount' => $amount,
                ]);
            });
        });
    }
}
