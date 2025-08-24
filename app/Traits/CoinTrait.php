<?php

namespace App\Traits;

trait CoinTrait
{
    public function calculateCoins($amount): float|int
    {
        $packageAmount = $amount;

        return round($packageAmount / settings('coin_price'), 8);
    }

    public function calculateCoinsDollar($amount): float|int
    {
        return round($amount * settings('coin_price'), 8);
    }
}
