<?php

namespace App\Jobs\Admin;

use App\Models\Admin;
use App\Models\IncomeWalletTransfer;
use App\Models\MagicPoolIncome;
use App\Models\Member;
use App\Models\Payout;
use App\Models\PayoutMember;
use App\Models\ReferralBonusIncome;
use App\Models\TeamBonusIncome;
use App\Models\WalletTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class GeneratePayout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * @throws Throwable
     */
    public function handle()
    {
        $payout = Payout::create();

        Member::with('kyc')
            ->eligibleForPayout()
            ->where('wallet_balance', '>=', 500)
            ->chunkById(1000, function ($members) use ($payout) {
                foreach ($members as $member) {
                    $payoutMember = PayoutMember::create([
                        'member_id' => $member->id,
                        'payout_id' => $payout->id,
                        'amount' => 0,
                        'tds' => 0,
                        'admin_charge' => 0,
                        'total' => 0,
                        'comment' => '',
                        'status' => PayoutMember::STATUS_PENDING,
                    ]);

                    $member->walletTransactions()
                        ->whereNull('payout_member_id')
                        ->where('responsible_type', '!=', PayoutMember::class)
                        ->chunkById(1000, function ($walletTransactions) use ($payout, &$payoutMember) {

                            /** @var WalletTransaction $walletTransaction */
                            foreach ($walletTransactions as $walletTransaction) {
                                if ($walletTransaction->type == WalletTransaction::TYPE_CREDIT) {
                                    if ($walletTransaction->responsible_type == ReferralBonusIncome::class) {
                                        $payoutMember->referral_bonus_income += $walletTransaction->amount;
                                        $payout->referral_bonus_income += $walletTransaction->amount;
                                    }

                                    if ($walletTransaction->responsible_type == TeamBonusIncome::class) {
                                        $payoutMember->team_bonus_income += $walletTransaction->amount;
                                        $payout->team_bonus_income += $walletTransaction->amount;
                                    }

                                    if ($walletTransaction->responsible_type == MagicPoolIncome::class) {
                                        $payoutMember->magic_pool_bonus_income += $walletTransaction->amount;
                                        $payout->magic_pool_bonus_income += $walletTransaction->amount;
                                    }
                                }

                                if ($walletTransaction->type == WalletTransaction::TYPE_DEBIT) {
                                    if ($walletTransaction->responsible_type == IncomeWalletTransfer::class) {
                                        $payoutMember->transfer_to_fund_wallet += $walletTransaction->amount;
                                        $payout->transfer_to_fund_wallet += $walletTransaction->amount;
                                    }

                                    if ($walletTransaction->responsible_type == MagicPoolIncome::class) {
                                        $payoutMember->magic_pool_upgrade += $walletTransaction->amount;
                                        $payout->magic_pool_upgrade += $walletTransaction->amount;
                                    }
                                }

                                if ($walletTransaction->responsible_type == Admin::class) {
                                    if ($walletTransaction->type == WalletTransaction::TYPE_CREDIT) {
                                        $payoutMember->admin_credit += $walletTransaction->amount;
                                        $payout->admin_credit += $walletTransaction->amount;
                                    } else {
                                        $payoutMember->admin_debit += $walletTransaction->amount;
                                        $payout->admin_debit += $walletTransaction->amount;
                                    }
                                }

                                if ($walletTransaction->type == WalletTransaction::TYPE_CREDIT) {
                                    $payoutMember->amount += $walletTransaction->amount;

                                    $payout->amount += $walletTransaction->amount;
                                } else {
                                    $payoutMember->amount -= $walletTransaction->amount;

                                    $payout->amount -= $walletTransaction->amount;
                                }

                                $walletTransaction->payout_member_id = $payoutMember->id;
                                $walletTransaction->save();
                            }

                            $adminChargePercent = settings('admin_charge_percent');
                            $adminCharge = $payoutMember->amount * $adminChargePercent / 100;

                            $tdsPercent = settings('tds_percent');
                            $tds = $payoutMember->amount * $tdsPercent / 100;
                            $payableAmount = $payoutMember->amount - $adminCharge - $tds;

                            $payoutMember->admin_charge = $adminCharge;
                            $payoutMember->total = $payableAmount;
                            $payoutMember->tds = $tds;

                            $payoutMember->payable_amount = $payableAmount;

                            $payout->admin_charge += $payoutMember->admin_charge;
                            $payout->total += $payoutMember->total;
                            $payout->tds += $payoutMember->tds;
                            $payout->payable_amount += $payoutMember->payable_amount;
                        });

                    $payoutMember->pan_card = $member->kyc->pan_card;
                    $payoutMember->aadhaar_card = $member->kyc->aadhaar_card;
                    $payoutMember->account_name = $member->kyc->account_name;
                    $payoutMember->account_number = $member->kyc->account_number;
                    $payoutMember->account_type = $member->kyc->account_type;
                    $payoutMember->bank_name = $member->kyc->bank_name;
                    $payoutMember->bank_branch = $member->kyc->bank_branch;
                    $payoutMember->bank_ifsc = $member->kyc->bank_ifsc;

                    $payoutMember->save();

                    $payoutMember->update([
                        'status' => PayoutMember::STATUS_COMPLETE,
                        'comment' => 'Payout Generated',
                    ]);

                    $amount = $payoutMember->amount;

                    $member->walletTransactions()->create([
                        'opening_balance' => $amount,
                        'closing_balance' => 0,
                        'amount' => $amount,
                        'tds' => 0.00,
                        'admin_charge' => 0.00,
                        'total' => $amount,
                        'type' => WalletTransaction::TYPE_DEBIT,
                        'responsible_id' => $payoutMember->id,
                        'responsible_type' => PayoutMember::class,
                        'comment' => 'Payout Generated',
                    ]);
                }
            });

        $payout->status = Payout::STATUS_COMPLETED;
        $payout->save();

        $payout->payoutMembers()
            ->chunkById(1000, function ($payoutMembers) {
                foreach ($payoutMembers as $payoutMember) {
                    if (settings('sms_enabled')) {
                        SendPayoutSMS::dispatch($payoutMember);
                    }
                }
            });
    }
}
