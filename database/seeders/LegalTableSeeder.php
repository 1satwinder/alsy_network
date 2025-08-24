<?php

namespace Database\Seeders;

use App\Models\LegalDocument;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\DiskDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class LegalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            $Legaldocuments = LegalDocument::create([
                'name' => 'Document 1',
                'status' => LegalDocument::STATUS_ACTIVE,
            ]);

            $Legaldocuments->addMedia(database_path('seeders/assets/legal/'.$i.'.jpg'))
                ->preservingOriginal()
                ->toMediaCollection(LegalDocument::MC_LEGAL_DOCUMENTS);
        }
    }
}
