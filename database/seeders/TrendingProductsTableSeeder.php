<?php

namespace Database\Seeders;

use App\Models\TrendingProducts;
use Illuminate\Database\Seeder;

class TrendingProductsTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 8; $i++) {
            TrendingProducts::create([
                'product_id' => $i,
            ]);
        }
    }
}
