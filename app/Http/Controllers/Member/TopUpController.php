<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Jobs\AddMemberOnPool;
use App\Jobs\CalculateReferralBonusIncome;
use App\Jobs\CalculateRewardBonusIncome;
use App\Jobs\CalculateTeamBonusIncome;
use App\Jobs\Member\SendActivationSMS;
use App\ListBuilders\Member\TopUpListBuilder;
use App\Models\FundWalletTransaction;
use App\Models\MagicPool;
use App\Models\Member;
use App\Models\Package;
use App\Models\TopUp;
use Auth;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class TopUpController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Renderable|RedirectResponse|JsonResponse
    {
        return TopUpListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): Renderable|RedirectResponse
    {
        $this->validate($request, [
            'package_id' => 'required|exists:packages,id',
        ], [
            'package_id.required' => 'The package is required',
            'package_id.exists' => 'The package is invalid',
        ]);

        if ($request->get('topup_type') == TopUp::TYPE_OTHER) {
            $this->validate($request, [
                'code' => 'required|exists:members,code',
            ], [
                'code.required' => 'The Member ID is required',
                'code.exists' => 'The selected member ID is invalid',
            ]);
        }

        try {
            return DB::transaction(function () use ($request) {

                if ($request->get('topup_type') == TopUp::TYPE_OTHER) {
                    $member = Member::whereCode($request->get('code'))->lockForUpdate()->first();
                } else {
                    $member = Member::whereCode($this->member->code)->lockForUpdate()->first();
                }

                $loginMember = Member::where('id', $this->member->id)->lockForUpdate()->first();

                $package = Package::whereId($request->input('package_id'))->first();
                if ($package->isInActive()) {
                    return redirect()->back()->with('error', 'Package not found')->withInput();
                }

                if ($member->isBlocked()) {
                    return redirect()->back()->with('error', 'Member ID is blocked.')->withInput();
                }

                if ($package->amount > $loginMember->fund_wallet_balance) {
                    return redirect()->route('member.topups.create')->withInput()
                        ->with('error', 'You do not have enough balance for this transaction');
                }

                if ($member->status == Member::STATUS_FREE_MEMBER) {
                    $member->status = Member::STATUS_ACTIVE;
                    $member->package_id = $package->id;

                    if (settings('sms_enabled')) {
                        SendActivationSMS::dispatch($member);
                    }
                }
                $member->save();
                $topup = $member->topUps()->create([
                    'package_id' => $package->id,
                    'amount' => $package->amount,
                    'topped_up_by' => Auth::user()->member->id,
                ]);

                $loginMember->fundWalletTransactions()->create([
                    'opening_balance' => $loginMember->fund_wallet_balance,
                    'closing_balance' => $loginMember->fund_wallet_balance - $topup->amount,
                    'amount' => $topup->amount,
                    'total' => $topup->amount,
                    'type' => FundWalletTransaction::TYPE_DEBIT,
                    'tds' => 0,
                    'admin_charge' => 0,
                    'responsible_id' => $topup->id,
                    'responsible_type' => TopUp::class,
                    'comment' => 'Topup applied for '.$member->user->name.'('.$member->code.')',
                ]);

                if ($member->sponsor) {
                    CalculateReferralBonusIncome::dispatch($topup);
                    CalculateTeamBonusIncome::dispatch($topup);
                }
                AddMemberOnPool::dispatch($topup->member, MagicPool::first());
                CalculateRewardBonusIncome::dispatch($topup->member);

                return redirect()->route('member.topups.index')->with('success', 'TopUp applied successfully.');
            });

        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function create(): Renderable|RedirectResponse
    {
        return view('member.topups.create', [
            'member' => Auth::user()->member,
            'packages' => Package::orderBy('id', 'desc')
                ->whereStatus(Package::STATUS_ACTIVE)
                ->with('products')->get(),
        ]);
    }
}
