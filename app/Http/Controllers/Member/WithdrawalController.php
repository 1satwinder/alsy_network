<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\ListBuilders\Member\WithdrawalRequestListBuilder;
use App\Models\WalletTransaction;
use App\Models\WithdrawalRequest;
use Brick\Math\Exception\MathException;
use Brick\Math\Exception\RoundingNecessaryException;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class WithdrawalController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return WithdrawalRequestListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:500',
        ], [
            'amount.min' => 'The amount must be at least 500',
        ]);

        if (! $this->member->isActive()) {
            return redirect()->back()->with('error', 'Member must be active for the withdrawal request')->withInput();
        }

        if (! $this->member->kyc) {
            return redirect()->back()->with(['error' => 'Please get your KYC approved to create a withdrawal request'])->withInput();
        } else {
            if (! $this->member->kyc->isApproved()) {
                return redirect()->back()->with(['error' => 'Please get your KYC approved to create a withdrawal request'])->withInput();
            }
        }

        if ($this->member->wallet_balance < $request->get('amount')) {
            return redirect()->back()->with(['error' => 'You do not have sufficient balance to create this withdraw request'])->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $member = $this->member;
                $amount = $request->get('amount');
                $adminChargePercent = settings('admin_charge_percent');
                $tdsPercent = settings('tds_percent');

                $adminCharge = $amount * $adminChargePercent / 100;
                $tds = $amount * $tdsPercent / 100;

                $total = $amount - $adminCharge - $tds;
                $withdrawalRequest = WithdrawalRequest::create([
                    'member_id' => $member->id,
                    'amount' => $amount,
                    'admin_charge' => $adminCharge,
                    'tds' => $tds,
                    'total' => $total,
                    'status' => WithdrawalRequest::STATUS_PENDING,
                ]);

                WalletTransaction::create([
                    'member_id' => $member->id,
                    'opening_balance' => $member->wallet_balance,
                    'closing_balance' => $member->wallet_balance - $amount,
                    'amount' => $amount,
                    'tds' => 0.00,
                    'admin_charge' => 0.00,
                    'total' => $amount,
                    'type' => WalletTransaction::TYPE_DEBIT,
                    'responsible_id' => $withdrawalRequest->id,
                    'responsible_type' => WithdrawalRequest::class,
                    'comment' => "Withdrawal Request $withdrawalRequest->id",
                ]);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again')->withInput();
        }

        return redirect()->route('member.withdrawals.index')->with(['success' => 'Withdrawal request created successfully']);
    }

    public function create()
    {
        return view('member.withdrawal.create');
    }

    /**
     * @throws MathException
     * @throws RoundingNecessaryException
     */
    public function calculation(Request $request): JsonResponse
    {
        $amount = $request->input('amount');
        $adminCharge = $amount * settings('admin_charge_percent') / 100;
        $tds = $amount * settings('tds_percent') / 100;
        $total = $amount - $adminCharge - $tds;

        return response()->json([
            'status' => true,
            'tds' => round($tds, 2),
            'adminCharge' => round($adminCharge, 2),
            'total' => round($total, 2),
        ]);
    }
}
