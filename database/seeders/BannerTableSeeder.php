<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            $banner = Banner::create([
                'name' => '',
                'status' => Banner::STATUS_ACTIVE,
            ]);

            $banner->addMedia(database_path('seeders/assets/slider/slider'.$i.'.png'))
                ->preservingOriginal()
                ->toMediaCollection(Banner::MC_BANNER);
        }
    }
}
