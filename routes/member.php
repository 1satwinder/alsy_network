<?php

Route::group([
    'namespace' => 'Member',
    'as' => 'member.',
    'prefix' => 'member',
], function () {
    Route::get('', 'LoginController@create')->name('login.create');
    Route::post('login', 'LoginController@store')->name('login.store');

    Route::get('register', 'RegisterController@create')->name('register.create');
    Route::post('register', 'RegisterController@store')->name('register.store');

    Route::post('send-otp', 'RegisterController@sendOtp')->name('send-otp');
    Route::post('get-otp-time', 'RegisterController@getOTPTime')->name('get-otp-time');

    Route::get('forgot-password', 'ForgotPasswordController@create')->name('forgot-password.create');
    Route::post('forgot-password', 'ForgotPasswordController@store')->name('forgot-password.store');

    Route::post('send-otp-forgot-password', 'ForgotPasswordController@sendOtp')->name('send-otp-forgot-password');
    Route::post('get-forgot-password-otp-time', 'ForgotPasswordController@getOTPTime')->name('get-forgot-password-otp-time');

    Route::group([
        'middleware' => ['memberAuth'],
    ], function () {
        Route::get('logout', 'LoginController@destroy')->name('login.destroy');
        Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
        Route::get('members/{member}/show', 'MemberController@show')->name('members.show');
        Route::get('id-card', 'IDCardController@show')->name('id-card');

        Route::get('toggle-theme', 'ToggleThemeController@update')->name('toggle-theme');

        Route::group([
            'prefix' => 'profile',
            'as' => 'profile.',
        ], function () {
            Route::get('', 'ProfileController@show')->name('show');
            Route::post('update', 'ProfileController@update')->name('update');
        });

        Route::get('invoice-list', 'InvoiceController@index')->name('invoice.index');
        Route::get('invoice/{topUp}', 'InvoiceController@show')->name('invoice.show');

        Route::get('kyc', 'KYCController@show')->name('kycs.show');
        Route::put('kyc', 'KYCController@update')->name('kycs.update');

        Route::post('change-password', 'ChangePasswordController@update')->name('change-password.update');
        Route::post('financial-change-password', 'FinancialChangePasswordController@update')->name('financial-change-password.update');

        Route::group(['prefix' => 'genealogy', 'as' => 'genealogy.'], function () {
            Route::get('{member?}', 'GenealogyController@show')->name('show');
        });

        Route::group(['prefix' => 'sponsor-genealogy', 'as' => 'sponsor-genealogy.'], function () {
            Route::get('{member?}', 'SponsorGenealogyController@sponsorShow')->name('show');
        });

        Route::get('autopool/show/{magicPool}/{code?}', 'AutopoolController@index')
            ->name('autopool.show');

        Route::group(['prefix' => 'pins', 'as' => 'pins.'], function () {
            Route::get('', 'PinController@index')->name('index');
            Route::get('{code}/show', 'PinController@show')->name('show');
        });

        Route::group([
            'prefix' => 'pin-transfers',
            'as' => 'pin-transfers.',
        ], function () {
            Route::post('member', 'PinTransferController@member')->name('member');
            Route::post('store', 'PinTransferController@store')->name('store');
        });

        Route::group([
            'prefix' => 'pin-requests',
            'as' => 'pin-requests.',
        ], function () {
            Route::get('', 'PinRequestController@index')->name('index');
            Route::get('create', 'PinRequestController@create')->name('create');
            Route::post('', 'PinRequestController@store')->name('store');
        });

        Route::group([
            'prefix' => 'topups',
            'as' => 'topups.',
        ], function () {
            Route::get('', 'TopUpController@index')->name('index');
            Route::get('create', 'TopUpController@create')->name('create');
            Route::post('store', 'TopUpController@store')->name('store');
        });

        Route::group([
            'prefix' => 'withdrawals',
            'as' => 'withdrawals.',
        ], function () {
            Route::get('', 'WithdrawalController@index')->name('index');
            Route::get('create', 'WithdrawalController@create')->name('create');
            Route::post('store', 'WithdrawalController@store')->name('store');
            Route::get('calculation', 'WithdrawalController@calculation')->name('calculation');
        });

        Route::get('wallet-transactions', 'WalletTransactionController@index')->name('wallet-transactions.index');
        Route::get('fund-wallet-transactions', 'FundWalletTransactionController@index')->name('fund-wallet-transactions.index');

        Route::group([
            'prefix' => 'income-wallet-transfer',
            'as' => 'income-wallet-transfer.',
        ], function () {
            Route::get('', 'IncomeWalletTransferController@index')->name('index');
            Route::get('create', 'IncomeWalletTransferController@create')->name('create');
            Route::post('', 'IncomeWalletTransferController@store')->name('store');
        });

        Route::group([
            'prefix' => 'fund-requests',
            'as' => 'fund-requests.',
        ], function () {
            Route::get('', 'FundRequestController@index')->name('index');
            Route::get('create', 'FundRequestController@create')->name('create');
            Route::post('', 'FundRequestController@store')->name('store');
        });

        Route::group([
            'prefix' => 'fund-wallet-transfer',
            'as' => 'fund-wallet-transfer.',
        ], function () {
            Route::get('', 'FundWalletTransferController@index')->name('index');
            Route::get('create', 'FundWalletTransferController@create')->name('create');
            Route::post('', 'FundWalletTransferController@store')->name('store');
        });

        Route::group([
            'prefix' => 'payouts',
            'as' => 'payouts.',
        ], function () {
            Route::get('', 'PayoutController@index')->name('index');
        });

        Route::group([
            'prefix' => 'reports',
            'as' => 'reports.',
        ], function () {
            Route::get('direct', 'ReportController@direct')->name('direct');
            Route::get('downline', 'ReportController@myDownline')->name('downline');
            Route::get('tds', 'ReportController@tds')->name('tds');
            Route::any('reward', 'ReportController@reward')->name('reward');
            Route::get('my-team', 'ReportController@level')->name('my-team');
            Route::get('magic-pool', 'ReportController@magicPool')->name('magic-pool');
            Route::get('level-detail/{level?}', 'ReportController@memberLevelDetail')->name('level-detail');
            Route::get('reward-achiever', 'ReportController@rewardAchiever')->name('reward-achiever');
        });

        Route::get('exports', 'ExportController@index')->name('exports.index');

        Route::get('banks', 'BankController@index')->name('banks.index');
        //        Route::post('support-tickets', 'SupportTicketController@store')->name('support-tickets.store');
        //        Route::any('support', 'SupportTicketController@index')->name('support-tickets.index');

        Route::group([
            'prefix' => 'support',
            'as' => 'support.',
        ], function () {
            Route::get('', 'SupportTicketController@index')->name('index');
            Route::get('create', 'SupportTicketController@create')->name('create');
            Route::post('', 'SupportTicketController@store')->name('store');
            Route::get('{id}/ticket', 'SupportTicketController@ticket')->name('ticket');
            Route::post('{id}/ticket-message', 'SupportTicketController@ticketMessage')->name('ticketMessage');
        });

        Route::group([
            'prefix' => 'product',
            'as' => 'product.',
        ], function () {
            Route::any('list/{category_prefix?}', 'ProductController@index')->name('index');
            Route::get('detail/{product}', 'ProductController@detail')->name('detail');
        });

        Route::group([
            'prefix' => 'orders',
            'as' => 'orders.',
        ], function () {
            Route::get('', 'OrderController@index')->name('index');
            Route::get('{order}/order-product', 'OrderController@show')->name('order-product');
            Route::get('invoice/{order}', 'OrderController@invoiceDetails')->name('invoice');
        });

        Route::group([
            'prefix' => 'welcome-letter',
            'as' => 'welcome-letter.',
        ], function () {
            Route::get('', 'WelcomeLetterController@download')->name('download');
        });

        Route::group([
            'prefix' => 'incomes',
            'as' => 'incomes.',
        ], function () {
            Route::get('referral-bonus-income', 'IncomeController@referralBonusIncome')->name('referral-bonus-income');
            Route::get('team-bonus-income', 'IncomeController@teamBonusIncome')->name('team-bonus-income');
            Route::get('reward-bonus-income', 'IncomeController@rewardBonusIncome')->name('reward-bonus-income');
            Route::get('magic-pool-bonus-income', 'IncomeController@magicPoolBonusIncome')->name('magic-pool-bonus-income');
        });

        Route::group([
            'prefix' => 'video',
            'as' => 'video.',
        ], function () {
            Route::get('', 'VideoController@index')->name('index');
        });
    });
});
