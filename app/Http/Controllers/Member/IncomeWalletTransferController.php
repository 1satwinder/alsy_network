<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\ListBuilders\Member\IncomeWalletTransferListBuilder;
use App\Models\IncomeWalletTransfer;
use App\Models\Member;
use App\Models\WalletTransaction;
use Auth;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class IncomeWalletTransferController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return IncomeWalletTransferListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    public function create(): RedirectResponse|Renderable
    {
        return view('member.income-wallet-transfer.create', [
            'member' => Auth::user()->member,
        ]);
    }

    /**
     * @throws Throwable
     * @throws ValidationException
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse|Renderable
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1',
        ], [
            'amount.required' => 'The amount is required',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 1.',
        ]);

        $member = Member::whereId($this->member->id)->lockForUpdate()->first();

        if ($member->status == Member::STATUS_BLOCKED) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['error' => 'You are blocked by admin']);
        }

        if ($request->get('amount') > $member->wallet_balance) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['error' => 'You do not have enough balance for this transaction']);
        }

        try {
            DB::transaction(function () use ($request, $member) {
                $amount = $request->get('amount');
                $adminCharge = ($amount * settings('admin_charge_percent')) / 100;

                $total = $amount - $adminCharge;

                $incomeWalletTransfer = IncomeWalletTransfer::create([
                    'member_id' => $member->id,
                    'amount' => $request->get('amount'),
                    'admin_charge' => $adminCharge,
                    'total' => $total,
                ]);

                $incomeWalletTransfer->member->walletTransactions()->create([
                    'opening_balance' => $incomeWalletTransfer->member->wallet_balance,
                    'closing_balance' => $incomeWalletTransfer->member->wallet_balance - $incomeWalletTransfer->amount,
                    'amount' => $incomeWalletTransfer->amount,
                    'tds' => 0.00,
                    'admin_charge' => 0.00,
                    'v_d_m_charge' => 0.00,
                    'total' => $incomeWalletTransfer->amount,
                    'type' => WalletTransaction::TYPE_DEBIT,
                    'responsible_id' => $incomeWalletTransfer->id,
                    'responsible_type' => IncomeWalletTransfer::class,
                    'comment' => 'Transfer to fund wallet',
                ]);

                $incomeWalletTransfer->member->fundWalletTransactions()->create([
                    'opening_balance' => $incomeWalletTransfer->member->fund_wallet_balance,
                    'closing_balance' => $incomeWalletTransfer->member->fund_wallet_balance + $incomeWalletTransfer->total,
                    'amount' => $incomeWalletTransfer->total,
                    'tds' => 0.00,
                    'admin_charge' => 0.00,
                    'total' => $incomeWalletTransfer->total,
                    'type' => WalletTransaction::TYPE_CREDIT,
                    'responsible_id' => $incomeWalletTransfer->id,
                    'responsible_type' => IncomeWalletTransfer::class,
                    'comment' => 'Received from income wallet',
                ]);

            });

            return redirect()->route('member.income-wallet-transfer.index')
                ->with('success', 'Amount successfully transferred to fund wallet');
        } catch (Exception $e) {
            return $this->logExceptionAndRespond($e);
        }
    }
}
