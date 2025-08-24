<?php

namespace Database\Seeders;

use App\Jobs\AddMemberOnPool;
use App\Models\Admin;
use App\Models\MagicPool;
use App\Models\Member;
use App\Models\Package;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Database\Seeder;
use Throwable;

class DatabaseSeeder extends Seeder
{
    /**
     * @throws Throwable
     */
    public function run(): void
    {
        DB::transaction(function () {
            if (User::count() == 0) {
                $this->call(CountryStateCityTableSeeder::class);
                $this->call(RolesTableSeeder::class);
                $this->call(PermissionsTableSeeder::class);
                $this->call(SettingsTableSeeder::class);
                $this->call(PackageTableSeeder::class);
                $this->call(BannerTableSeeder::class);
                $this->call(TeamBonusTableSeeder::class);
                $this->call(RewardBonusTableSeeder::class);
                $this->call(MagicPoolTableSeeder::class);

                $user = Admin::create([
                    'name' => 'Alsy Network',
                    'email' => 'alsy-network@gmail.com',
                    'mobile' => '9999999999',
                    'password' => Hash::make('company@123'),
                    'is_super' => true,
                ]);

                Auth::shouldUse('admin');
                $user->assignRole('admin');

                $user = User::create([
                    'name' => 'Alsy Network',
                    'email' => 'mlm-alsy-network@gmail.com',
                    'mobile' => '9999999999',
                    'password' => Hash::make('company@123'),
                    'financial_password' => Hash::make('company@123'),
                ]);
                Auth::shouldUse('member');
                $user->assignRole('member');

                $package = Package::find(1);

                $member = Member::create([
                    'user_id' => $user->id,
                    'sponsor_id' => null,
                    'code' => env('APP_ENV') != 'production' ? '10000001' : null,
                    'level' => 1,
                    'status' => Member::STATUS_ACTIVE,
                    'package_id' => $package->id,
                    'sponsor_path' => '1',
                    'is_paid' => Member::IS_PAID,
                    'activated_at' => Carbon::now(),
                ]);

                $topUp = $member->topUps()->create([
                    'package_id' => $package->id,
                    'amount' => $package->amount,
                    'topped_up_by' => $member->id,
                ]);

                AddMemberOnPool::dispatch($topUp->member, MagicPool::first());
            }

            if (env('APP_ENV') != 'production') {
                $this->call(BanksTableSeeder::class);
                //                $this->call(MembersTableSeeder::class);
                $this->call(KYCsTableSeeder::class);
                $this->call(PinRequestsTableSeeder::class);
                $this->call(FaqsTableSeeder::class);
                $this->call(NewsTableSeeder::class);
                $this->call(LegalTableSeeder::class);
                $this->call(MemberLoginLogTableSeeder::class);

                if (settings('is_ecommerce')) {
                    $this->call(CategoriesTableSeeder::class);
                    $this->call(ProductsTableSeeder::class);
                    $this->call(TrendingProductsTableSeeder::class);
                    $this->call(CategorySliderTableSeeder::class);
                }
            }
        });
    }
}
