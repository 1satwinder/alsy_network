<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\IncomeWalletTransfer;
use App\Models\MagicPoolIncome;
use App\Models\Member;
use App\Models\Payout;
use App\Models\ReferralBonusIncome;
use App\Models\TeamBonusIncome;
use App\Models\WalletTransaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PreviewPayoutController extends Controller
{
    public function show(): View|Factory|RedirectResponse|Application
    {
        if (Payout::whereStatus(Payout::STATUS_PENDING)->exists()) {
            return redirect()
                ->route('admin.payouts.index')
                ->with(['error' => 'A payout is already processing. Please try again after all payouts have completed processing']);
        }

        $totalPayableAmount = 0;

        $members = Member::eligibleForPayout()
            ->where('wallet_balance', '>=', 500)
            ->with([
                'user',
                'walletTransactions' => function ($query) {
                    return $query->eligibleForPayout();
                },
            ])
            ->get()
            ->map(function (Member $member) use (&$totalPayableAmount) {
                $creditTransactions = $member->walletTransactions->where('type', WalletTransaction::TYPE_CREDIT);
                $debitTransactions = $member->walletTransactions->where('type', WalletTransaction::TYPE_DEBIT);

                $referralBonusIncome = $creditTransactions
                    ->where('responsible_type', ReferralBonusIncome::class)
                    ->sum('amount');

                $teamBonusIncome = $creditTransactions
                    ->where('responsible_type', TeamBonusIncome::class)
                    ->sum('amount');

                $magicPoolIncome = $creditTransactions
                    ->where('responsible_type', MagicPoolIncome::class)
                    ->sum('amount');

                $adminCredit = $creditTransactions
                    ->where('responsible_type', Admin::class)
                    ->sum('amount');
                $adminDebit = $debitTransactions
                    ->where('responsible_type', Admin::class)
                    ->sum('amount');

                $magicPoolUpgrade = $debitTransactions
                    ->where('responsible_type', MagicPoolIncome::class)
                    ->sum('amount');

                $transferToFundWallet = $debitTransactions
                    ->where('responsible_type', IncomeWalletTransfer::class)
                    ->sum('amount');

                $amount = $creditTransactions->sum('amount') - $debitTransactions->sum('amount');
                $adminCharge = ($amount * settings('admin_charge_percent')) / 100;
                $tds = ($amount * settings('tds_percent')) / 100;
                $total = $amount - $adminCharge - $tds;
                $payableAmount = $total;
                $totalPayableAmount += $payableAmount;

                return (object) [
                    'id' => $member->id,
                    'code' => $member->code,
                    'name' => $member->user->name,
                    'referralBonusIncome' => $referralBonusIncome,
                    'teamBonusIncome' => $teamBonusIncome,
                    'magicPoolIncome' => $magicPoolIncome,
                    'adminCredit' => $adminCredit,
                    'adminDebit' => $adminDebit,
                    'transferToFundWallet' => $transferToFundWallet,
                    'magicPoolUpgrade' => $magicPoolUpgrade,
                    'amount' => $amount,
                    'adminCharge' => $adminCharge,
                    'total' => $payableAmount,
                    'tds' => $tds,
                    'payableAmount' => $payableAmount,
                ];
            });

        return view('admin.payouts.preview', [
            'members' => $members,
            'totalPayableAmount' => $totalPayableAmount,
        ]);
    }
}
