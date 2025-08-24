<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\AddMemberOnPool;
use App\Jobs\CalculateReferralBonusIncome;
use App\Jobs\CalculateRewardBonusIncome;
use App\Jobs\CalculateTeamBonusIncome;
use App\Models\MagicPool;
use App\Models\Member;
use App\Models\Package;
use App\Models\User;
use Auth;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Throwable;

class AddMemberController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        $sponsor = Member::whereCode($request->get('sponsor_code'))->first();
        $count = $request->get('count');

        if (! $count) {
            $count = 1;
        }

        if (! $sponsor) {
            exit('Sponsor not found');
        }

        try {
            for ($i = 0; $i < $count; $i++) {
                /** @var Member $member */
                DB::transaction(function () use ($sponsor) {
                    $user = User::create([
                        'name' => Member::count() + 1,
                        'email' => 'adc@gmail.com',
                        'mobile' => '9999998888',
                        'password' => Hash::make('Company@123'),
                        'financial_password' => Hash::make('Company@123'),
                    ]);

                    Auth::shouldUse('member');
                    $user->assignRole('member');

                    $package = Package::first();

                    $member = Member::create([
                        'user_id' => $user->id,
                        'sponsor_id' => $sponsor->id,
                        'level' => $sponsor->level + 1,
                        'status' => Member::STATUS_ACTIVE,
                        'package_id' => $package->id,
                        'activated_at' => now(),
                        'is_paid' => Member::IS_PAID,
                    ]);

                    $topup = $member->topUps()->create([
                        'package_id' => $package->id,
                        'amount' => $package->amount,
                        'topped_up_by' => $member->id,
                    ]);

                    if ($member->sponsor) {
                        CalculateReferralBonusIncome::dispatch($topup);
                        CalculateTeamBonusIncome::dispatch($topup);
                    }

                    AddMemberOnPool::dispatch($topup->member, MagicPool::first());
                    CalculateRewardBonusIncome::dispatch($topup->member);

                });
            }
        } catch (Throwable $e) {
            dd($e);

            return $this->logExceptionAndRespond($e);
        }
    }
}
