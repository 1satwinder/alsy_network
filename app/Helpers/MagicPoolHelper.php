<?php

namespace App\Helpers;

use App\Models\Package;

class MagicPoolHelper
{
    /**
     * Calculate the magic pool allocation amount for a given package
     * 
     * @param Package|int $package Package model or package ID
     * @return float Fixed allocation amount
     */
    public static function calculateAllocationAmount($package): float
    {
        // Always return fixed amount regardless of package price
        return config('magic_pool.fixed_allocation_amount', 200);
    }

    /**
     * Calculate the magic pool allocation amount for a package by ID
     * 
     * @param int $packageId
     * @return float Fixed allocation amount
     */
    public static function calculateAllocationAmountById(int $packageId): float
    {
        return self::calculateAllocationAmount($packageId);
    }

    /**
     * Get the fixed allocation amount from config
     * 
     * @return float
     */
    public static function getFixedAllocationAmount(): float
    {
        return config('magic_pool.fixed_allocation_amount', 200);
    }

    /**
     * Check if system uses fixed amount or percentage
     * 
     * @return bool
     */
    public static function usesFixedAmount(): bool
    {
        return config('magic_pool.use_fixed_amount', true);
    }

    /**
     * Get allocation percentage (for reference)
     * 
     * @return float
     */
    public static function getAllocationPercentage(): float
    {
        return config('magic_pool.allocation_percentage', 12.9);
    }
}
