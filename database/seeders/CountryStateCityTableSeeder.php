<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use DB;
use Illuminate\Database\Seeder;
use Throwable;

class CountryStateCityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Throwable
     */
    public function run(): void
    {
        $countries = collect(
            json_decode(file_get_contents(database_path('/seeders/assets/countries.json')))
        )->filter(fn ($country) => $country->name === 'India');

        $now = now()->toDateTimeString();

        $countryId = Country::count() + 1;
        $countryEntries = collect();

        $stateId = State::count() + 1;
        $stateEntries = collect();

        $cityEntries = collect();

        foreach ($countries as $country) {
            $countryCode = $country->phone_code;

            $regExDetail = '/^[1-9][0-9]{7,11}$/';
            if ($countryCode === '91') {
                $regExDetail = '/^[6789][0-9]{9}$/';
            }

            $countryEntries->push([
                'id' => $countryId,
                'name' => $country->name,
                'code' => $countryCode,
                'regex' => $regExDetail,
                'emoji' => $country->emoji,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($country->states as $state) {
                $stateEntries->push([
                    'id' => $stateId,
                    'name' => $state->name,
                    'country_id' => $countryId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                foreach ($state->cities as $city) {
                    $cityEntries->push([
                        'name' => $city->name,
                        'state_id' => $stateId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }

                $stateId++;
            }

            $countryId++;
        }

        unset($countries);

        DB::transaction(function () use ($countryEntries, $stateEntries, $cityEntries) {
            $countryEntries->chunk(5000)
                ->each(fn ($countryEntries) => Country::insert($countryEntries->toArray()));

            unset($countryEntries);

            $stateEntries->chunk(5000)
                ->each(fn ($stateEntries) => State::insert($stateEntries->toArray()));

            unset($stateEntries);

            $cityEntries->chunk(5000)
                ->each(fn ($cityEntries) => City::insert($cityEntries->toArray()));

            unset($cityEntries);
        });
    }
}
