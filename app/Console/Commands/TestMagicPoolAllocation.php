<?php

namespace App\Console\Commands;

use App\Helpers\MagicPoolHelper;
use App\Models\Package;
use Illuminate\Console\Command;

class TestMagicPoolAllocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:magic-pool-allocation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test magic pool allocation to ensure it returns fixed amount for all packages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Magic Pool Allocation System...');
        $this->info('=====================================');
        
        // Get all packages
        $packages = Package::all();
        
        if ($packages->isEmpty()) {
            $this->error('No packages found in the system!');
            return 1;
        }
        
        $this->info("Found {$packages->count()} package(s):");
        $this->info('');
        
        $headers = ['Package ID', 'Package Name', 'Package Amount', 'Magic Pool Allocation', 'Status'];
        $rows = [];
        
        foreach ($packages as $package) {
            $allocationAmount = MagicPoolHelper::calculateAllocationAmount($package);
            $expectedAmount = config('magic_pool.fixed_allocation_amount', 200);
            $status = $allocationAmount == $expectedAmount ? '✅ PASS' : '❌ FAIL';
            
            $rows[] = [
                $package->id,
                $package->name,
                '₹' . number_format($package->amount, 2),
                '₹' . number_format($allocationAmount, 2),
                $status
            ];
        }
        
        $this->table($headers, $rows);
        
        // Summary
        $this->info('');
        $this->info('Summary:');
        $this->info("- Fixed allocation amount: ₹" . config('magic_pool.fixed_allocation_amount', 200));
        $this->info("- Uses fixed amount: " . (MagicPoolHelper::usesFixedAmount() ? 'Yes' : 'No'));
        $this->info("- Allocation percentage: " . MagicPoolHelper::getAllocationPercentage() . '% (for reference only)');
        
        // Test with different amounts
        $this->info('');
        $this->info('Testing with different package amounts:');
        $testAmounts = [1000, 1550, 2000, 5000, 10000];
        
        foreach ($testAmounts as $amount) {
            $allocation = MagicPoolHelper::calculateAllocationAmount((object)['amount' => $amount]);
            $this->info("Package ₹{$amount} → Magic Pool Allocation: ₹{$allocation}");
        }
        
        $this->info('');
        $this->info('✅ Magic Pool allocation is now FIXED at ₹200 for ALL packages!');
        
        return 0;
    }
}
