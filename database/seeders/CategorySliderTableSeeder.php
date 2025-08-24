<?php

namespace Database\Seeders;

use App\Models\CategorySlider;
use Illuminate\Database\Seeder;

class CategorySliderTableSeeder extends Seeder
{
    public function run()
    {
        CategorySlider::create([
            'category_id' => '2',
            'status' => '1',
        ]);

        CategorySlider::create([
            'category_id' => '4',
            'status' => '1',
        ]);
    }
}
