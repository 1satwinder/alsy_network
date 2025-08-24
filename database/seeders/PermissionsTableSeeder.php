<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Throwable;

class PermissionsTableSeeder extends Seeder
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
                    'name' => 'Dashboard',
                ],
                [
                    'name' => 'Admins',
                ],
                [
                    'name' => 'Members',
                ],
                [
                    'name' => 'KYCS',
                ],
                [
                    'name' => 'Packages',
                ],
                [
                    'name' => 'Sponsor Genealogy Tree',
                ],
                [
                    'name' => 'Magic Pool Genealogy Tree',
                ],
                [
                    'name' => 'Member TDS Report',
                ],
                [
                    'name' => 'Income Wallet',
                ],
                [
                    'name' => 'Fund Wallet',
                ],
                [
                    'name' => 'Incomes',
                ],
                [
                    'name' => 'Reports',
                ],
                [
                    'name' => 'Reward Bonus',
                ],
                [
                    'name' => 'Payouts',
                ],
                [
                    'name' => 'Exports',
                ],
                [
                    'name' => 'GST Manager',
                ],
                [
                    'name' => 'Contact Inquiries',
                ],
                [
                    'name' => 'Support Ticket',
                ],
                [
                    'name' => 'Banking Partner',
                ],
                [
                    'name' => 'Website Settings',
                ],
            ])->each(function ($permission) {
                Permission::updateOrCreate([
                    'name' => $permission['name'].'-create',
                    'guard_name' => 'admin',
                ]);
                Permission::updateOrCreate([
                    'name' => $permission['name'].'-read',
                    'guard_name' => 'admin',
                ]);
                Permission::updateOrCreate([
                    'name' => $permission['name'].'-update',
                    'guard_name' => 'admin',
                ]);
                Permission::updateOrCreate([
                    'name' => $permission['name'].'-delete',
                    'guard_name' => 'admin',
                ]);
            });
        });
    }
}
