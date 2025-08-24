<?php

namespace App\Jobs;

use App\Models\MagicPool;
use App\Models\MagicPoolIncome;
use App\Models\MagicPoolTree;
use App\Models\WalletTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateMagicPoolIncome implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private MagicPoolTree $magicPoolMember;

    /**
     * Create a new job instance.
     */
    public function __construct(MagicPoolTree $magicPoolMember)
    {
        $this->magicPoolMember = $magicPoolMember;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->magicPoolMember->load('children');
        $magicPoolDetail = MagicPool::find($this->magicPoolMember->magic_pool_id);

        if ($this->magicPoolMember->children->count() >= $magicPoolDetail->total_member) {
            $income = MagicPoolIncome::create([
                'member_id' => $this->magicPoolMember->member_id,
                'magic_pool_tree_id' => $this->magicPoolMember->id,
                'magic_pool_id' => $this->magicPoolMember->magic_pool_id,
                'total_amount' => $magicPoolDetail->total_income,
                'upgrade_amount' => $magicPoolDetail->upgrade_amount,
                'net_amount' => $magicPoolDetail->net_income,
            ]);

            $income->walletTransaction()->create([
                'member_id' => $income->member->id,
                'opening_balance' => $income->member->wallet_balance,
                'closing_balance' => $income->member->wallet_balance + $income->total_amount,
                'amount' => $income->total_amount,
                'tds' => 0,
                'admin_charge' => 0,
                'total' => $income->total_amount,
                'type' => WalletTransaction::TYPE_CREDIT,
                'comment' => $magicPoolDetail->name.' income credited ',
            ]);

            $income->walletTransaction()->create([
                'member_id' => $income->member->id,
                'opening_balance' => $income->member->wallet_balance,
                'closing_balance' => $income->member->wallet_balance - $income->upgrade_amount,
                'amount' => $income->upgrade_amount,
                'tds' => 0,
                'admin_charge' => 0,
                'total' => $income->upgrade_amount,
                'type' => WalletTransaction::TYPE_DEBIT,
                'comment' => $magicPoolDetail->name.'upgrade amount debit',
            ]);

            $nextPool = MagicPool::find($magicPoolDetail->id + 1);
            if ($nextPool) {
                AddMemberOnPool::dispatch($this->magicPoolMember->member, $nextPool);
            }
        }
    }
}
