<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Magic Pool Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for the Magic Pool system
    | including fixed allocation amounts and other settings.
    |
    */

    // Fixed amount allocated to magic pool for ALL packages
    'fixed_allocation_amount' => 200,

    // Magic pool allocation percentage (if you want to keep both options)
    'allocation_percentage' => 12.9,

    // Use fixed amount instead of percentage
    'use_fixed_amount' => true,

    // Magic pool levels configuration
    'levels' => [
        1 => ['total_member' => 4, 'total_income' => 800, 'upgrade_amount' => 400, 'net_income' => 400],
        2 => ['total_member' => 4, 'total_income' => 1600, 'upgrade_amount' => 800, 'net_income' => 800],
        3 => ['total_member' => 4, 'total_income' => 3200, 'upgrade_amount' => 2000, 'net_income' => 1200],
        4 => ['total_member' => 4, 'total_income' => 8000, 'upgrade_amount' => 4000, 'net_income' => 4000],
        5 => ['total_member' => 4, 'total_income' => 16000, 'upgrade_amount' => 8000, 'net_income' => 8000],
        6 => ['total_member' => 4, 'total_income' => 32000, 'upgrade_amount' => 16000, 'net_income' => 16000],
        7 => ['total_member' => 4, 'total_income' => 64000, 'upgrade_amount' => 32000, 'net_income' => 32000],
        8 => ['total_member' => 4, 'total_income' => 128000, 'upgrade_amount' => 64000, 'net_income' => 64000],
        9 => ['total_member' => 4, 'total_income' => 256000, 'upgrade_amount' => 156000, 'net_income' => 100000],
        10 => ['total_member' => 4, 'total_income' => 624000, 'upgrade_amount' => 0, 'net_income' => 624000],
    ],
];
