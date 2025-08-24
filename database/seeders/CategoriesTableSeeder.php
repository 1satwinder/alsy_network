<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        collect([
            'Home & Living' => ['Bath', 'Home Decor', 'Lamp & Lighting'],
            'Grocery' => ['Staples', 'Packaging Food', 'HouseHold Care'],
            'Fashion' => ['Men', 'Women', 'Kids'],
            'Electronics' => ['Power Bank', 'Storage', 'Gaming'],
            'Appliances' => ['TV', 'Refrigerators', 'Washing Machines'],
            'Mobiles' => ['Samsung', 'RealMe', 'Apple', 'Mi'],
        ])->each(function ($children, $name) use (&$i) {
            $category = Category::factory()->create([
                'name' => $name,
            ]);
            $number = $i;
            $category->addMedia(database_path("seeders/assets/category/$number.webp"))
                ->preservingOriginal()
                ->toMediaCollection(Category::MC_CATEGORY_IMAGE);
            $i++;
            $category->save();
            foreach ($children as $child) {
                $subCat = Category::factory()->create([
                    'name' => $child,
                    'parent_id' => $category->id,
                ]);
                $number = mt_rand(1, 6);
                $subCat->addMedia(database_path("seeders/assets/category/$number.webp"))
                    ->preservingOriginal()
                    ->toMediaCollection(Category::MC_CATEGORY_IMAGE);
                $subCat->save();
            }
        });
    }
}
