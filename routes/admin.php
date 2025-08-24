<?php

Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('', 'LoginController@create')->name('login.create');
    Route::post('', 'LoginController@store')->name('login.store');
    Route::get('get/state/{country_id_or_name}', 'StateController@getState')->name('get-state');
    Route::get('get/city/{state_id_or_name}', 'StateController@getCity')->name('get-city');

    Route::get('forgot-password', 'ForgotPasswordController@create')->name('forgot-password.create');
    Route::post('forgot-password/send-otp', 'ForgotPasswordController@sendOtp')->name('forgot-password.send-otp');
    Route::post('forgot-password', 'ForgotPasswordController@store')->name('forgot-password.store');

    Route::group([
        'middleware' => ['adminAuth'],
    ], function () {
        Route::get('add-member', 'AddMemberController@index');
        Route::get('logout', 'LoginController@destroy')->name('login.destroy');
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('password/edit', 'PasswordController@edit')->name('password.edit');
        Route::post('password/update', 'PasswordController@update')->name('password.update');

        Route::get('toggle-theme', 'ToggleThemeController@update')->name('toggle-theme');

        Route::group(['prefix' => 'gst-types', 'as' => 'gst-types.'], function () {
            Route::get('', 'GSTTypeController@index')->name('index');
            Route::get('create', 'GSTTypeController@create')->name('create');
            Route::post('', 'GSTTypeController@store')->name('store');
            Route::get('{gstTypes}/edit', 'GSTTypeController@edit')->name('edit');
            Route::post('{gstTypes}/update', 'GSTTypeController@update')->name('update');
        });

        Route::group([
            'prefix' => 'members',
            'as' => 'members.',
        ], function () {
            Route::get('', 'MemberController@index')->name('index')->middleware('permission:Members-read');
            Route::get('{member}/show', 'MemberController@show')->name('show')->middleware('permission:Members-read');
            Route::get('{member}/edit', 'MemberController@edit')->name('edit')->middleware('permission:Members-update');
            Route::patch('{member}/update', 'MemberController@update')->name('update')->middleware('permission:Members-update');
            Route::get('{member}/log', 'MemberController@memberLog')->name('log')->middleware('permission:Members-read');

            Route::post('{member}/block', 'BlockMemberController@store')->name('block.store')->middleware('permission:Members-create');
            Route::delete('{member}/block', 'BlockMemberController@destroy')->name('block.destroy')->middleware('permission:Members-update');

            Route::get('{member}/change-password', 'ChangeMemberPasswordController@edit')->name('change-password.edit')->middleware('permission:Members-update');
            Route::patch('{member}/change-password', 'ChangeMemberPasswordController@update')->name('change-password.update')->middleware('permission:Members-update');
            Route::patch('{member}/transaction-change-password', 'ChangeMemberPasswordController@transactionChangePassword')->name('transaction-change-password.update')->middleware('permission:Members-update');

            Route::post('{member}/impersonate', 'MemberImpersonateController@store')
                ->name('impersonate.store')->middleware('permission:Members-read');
        });

        Route::group([
            'prefix' => 'admins',
            'as' => 'admins.',
        ], function () {
            Route::get('', 'AdminController@index')->name('index')->middleware('permission:Admins-read');
            Route::get('create', 'AdminController@create')->name('create')->middleware('permission:Admins-read');
            Route::post('store', 'AdminController@store')->name('store')->middleware('permission:Admins-create');
            Route::get('{admin}/edit', 'AdminController@edit')->name('edit')->middleware('permission:Admins-update');
            Route::post('{admin}/update', 'AdminController@update')->name('update')->middleware('permission:Admins-update');
            Route::get('{admin}/update-status', 'AdminController@updateStatus')->name('update-status')->middleware('permission:Admins-update');
            Route::get('{admin}/change-password', 'AdminController@changePassword')->name('change-password')->middleware('permission:Admins-update');
            Route::post('{admin}/change-password', 'AdminController@changePasswordUpdate')->name('change-password-update')->middleware('permission:Admins-update');
        });

        Route::group([
            'prefix' => 'kycs',
            'as' => 'kycs.',
        ], function () {
            Route::get('', 'KYCController@index')->name('index')->middleware('permission:KYCS-read');
            Route::get('{kyc}/show', 'KYCController@show')->name('show')->middleware('permission:KYCS-read');
            Route::get('{kyc}/edit', 'KYCController@edit')->name('edit')->middleware('permission:KYCS-update');
            Route::put('{kyc}', 'KYCController@update')->name('update')->middleware('permission:KYCS-update');
            Route::post('approve/{kyc}', 'ApproveKYCController@store')->name('approve')->middleware('permission:KYCS-update');
            Route::post('reject/{kyc}', 'RejectKYCController@store')->name('reject')->middleware('permission:KYCS-update');
        });

        Route::group([
            'prefix' => 'packages',
            'as' => 'packages.',
        ], function () {
            Route::get('', 'PackageController@index')->name('index')->middleware('permission:Packages-read');
            Route::get('create', 'PackageController@create')->name('create')->middleware('permission:Packages-create');
            Route::post('', 'PackageController@store')->name('store')->middleware('permission:Packages-create');
            Route::get('{package}/change-status', 'PackageController@changeStatus')->name('change-status')->middleware('permission:Packages-update');
        });

        Route::get('genealogy/show/{code?}', 'GenealogyController@show')->name('genealogy.show')->middleware('permission:Genealogy Tree-read');
        Route::get('sponsor-genealogy/show/{code?}', 'SponsorGenealogyController@show')->name('sponsor-genealogy.show')->middleware('permission:Sponsor Genealogy Tree-read');
        Route::get('autoPool/show/{magicPool}/{code?}', 'AutopoolController@index')->name('autoPool.show')->middleware('permission:Magic Pool Genealogy Tree-read');

        Route::group([
            'prefix' => 'pins',
            'as' => 'pins.',
        ], function () {
            Route::get('', 'PinController@index')->name('index')->middleware('permission:Pins-read');
            Route::get('create', 'PinController@create')->name('create')->middleware('permission:Pins-create');
            Route::post('', 'PinController@store')->name('store')->middleware('permission:Pins-create');

            Route::post('block/{pin}', 'BlockPinController@store')->name('block.store')->middleware('permission:Pins-update');
            Route::delete('block/{pin}', 'BlockPinController@destroy')->name('block.destroy')->middleware('permission:Pins-delete');
        });

        Route::group([
            'prefix' => 'pin-requests',
            'as' => 'pin-requests.',
        ], function () {
            Route::get('', 'PinRequestController@index')->name('index')->middleware('permission:Pin Request-read');

            Route::any('request/edit/{id}', 'PinController@requestUpdate')->name('request.update')->middleware('permission:Pin Request-update');
            Route::get('{pinRequest}/approve', 'ApprovePinRequestController@store')->name('approve')->middleware('permission:Pin Request-update');
            Route::get('{pinRequest}/reject', 'RejectPinRequestController@store')->name('reject')->middleware('permission:Pin Request-update');
        });

        Route::group([
            'prefix' => 'banking',
            'as' => 'banking.',
        ], function () {
            Route::get('create', 'BankDetailController@create')->name('create')->middleware('permission:Banking Partner-read');
            Route::post('store', 'BankDetailController@store')->name('store')->middleware('permission:Banking Partner-create');
            Route::get('index', 'BankDetailController@index')->name('show')->middleware('permission:Banking Partner-read');
            Route::get('edit/{id}', 'BankDetailController@edit')->name('edit')->middleware('permission:Banking Partner-update');
            Route::post('update/{id}', 'BankDetailController@update')->name('update')->middleware('permission:Banking Partner-update');
        });

        Route::group([
            'prefix' => 'payouts',
            'as' => 'payouts.',
        ], function () {
            Route::get('', 'PayoutController@index')->name('index')->middleware('permission:Payouts-read');
            Route::post('', 'PayoutController@store')->name('store')->middleware('permission:Payouts-create');
            Route::get('{id}/details', 'PayoutController@show')->name('details')->middleware('permission:Payouts-read');
            Route::get('preview', 'PreviewPayoutController@show')->name('preview.show')->middleware('permission:Payouts-read');
        });

        Route::group([
            'prefix' => 'wallet-transactions',
            'as' => 'wallet-transactions.',
        ], function () {
            Route::get('', 'WalletTransactionController@index')->name('index')->middleware('permission:Income Wallet-read');
            Route::get('create', 'WalletTransactionController@create')->name('create')->middleware('permission:Income Wallet-create');
            Route::post('', 'WalletTransactionController@store')->name('store')->middleware('permission:Income Wallet-create');
            Route::get('transfer', 'WalletTransactionController@transfer')->name('transfer')->middleware('permission:Income Wallet-read');
        });

        Route::get('tds', 'TdsReportController@index')->name('tds.index')->middleware('permission:Member TDS Report-read');
        Route::get('tds/show', 'TdsReportController@show')->name('tds.show')->middleware('permission:Member TDS Report-read');

        Route::group([
            'prefix' => 'reports',
            'as' => 'reports.',
        ], function () {
            Route::get('top-earners', 'ReportController@topEarners')->name('top-earners')->middleware('permission:Reports-read');
            Route::get('top-up', 'ReportController@topUp')->name('top-up')->middleware('permission:Reports-read');
            Route::get('{topUp}/view-invoice', 'InvoiceController@show')->name('view-invoice')->middleware('permission:Reports-read');
            Route::get('most-active-member', 'ReportController@mostActiveMember')->name('most-active-user')->middleware('permission:Reports-read');
            Route::get('pin-transfer', 'ReportController@pinTransfer')->name('pin-transfer')->middleware('permission:Reports-read');
            Route::any('reward', 'ReportController@reward')->name('reward')->middleware('permission:Reports-read');
            Route::any('level', 'ReportController@level')->name('level')->middleware('permission:Reports-read');
            Route::any('level-detail/{level?}', 'ReportController@levelDetail')->name('level-detail')->middleware('permission:Reports-read');

        });

        Route::get('exports', 'ExportController@index')->name('exports.index')->middleware('permission:Exports-read');

        Route::get('contact-inquiries', 'ContactInquiryController@index')->name('contactInquires.index')->middleware('permission:Contact Inquiries-read');

        Route::group([
            'prefix' => 'withdrawal-requests',
            'as' => 'withdrawal-requests.',
        ], function () {
            Route::get('', 'WithdrawalController@index')->name('index')->middleware('permission:Withdrawal Requests-read');
            Route::post('{withdrawalRequest}/update', 'WithdrawalController@update')->name('update')->middleware('permission:Withdrawal Requests-update');
            Route::post('status-update', 'WithdrawalController@statusUpdate')->name('status-update')->middleware('permission:Withdrawal Requests-update');
        });

        Route::group([
            'prefix' => 'support-ticket',
            'as' => 'support-ticket.',
        ], function () {
            Route::get('', 'SupportTicketController@get')->name('get')->middleware('permission:Support Ticket-read');
            Route::get('support-ticket-detail/{id}', 'SupportTicketController@getDetails')->name('details.get')->middleware('permission:Support Ticket-read');
            Route::post('send', 'SupportTicketController@store')->name('send')->middleware('permission:Support Ticket-update');
            Route::get('clear', 'SupportTicketController@clearAll')->name('clear')->middleware('permission:Support Ticket-delete');
        });

        Route::get('gst', 'GSTController@index')->name('gst.index')->middleware('permission:GST Manager-read');

        Route::group([
            'prefix' => 'legal',
            'as' => 'legal.',
        ], function () {
            Route::any('create', 'LegalDocumentController@create')->name('create')->middleware('permission:Website Settings-read');
            Route::post('', 'LegalDocumentController@store')->name('store')->middleware('permission:Website Settings-create');
            Route::post('{legalDocument}/update', 'LegalDocumentController@update')->name('update')->middleware('permission:Website Settings-update');
            Route::delete('{legalDocument}/destroy', 'LegalDocumentController@destroy')->name('destroy')->middleware('permission:Website Settings-delete');
        });

        Route::group([
            'prefix' => 'photo-gallery',
            'as' => 'photo-gallery.',
        ], function () {
            Route::get('index', 'PhotoGalleryController@index')->name('index')->middleware('permission:Website Settings-read');
            Route::get('create', 'PhotoGalleryController@create')->name('create')->middleware('permission:Website Settings-create');
            Route::post('store', 'PhotoGalleryController@store')->name('store')->middleware('permission:Website Settings-create');
            Route::get('{photoGallery}/edit', 'PhotoGalleryController@edit')->name('edit')->middleware('permission:Website Settings-update');
            Route::patch('{photoGallery}/update', 'PhotoGalleryController@update')->name('update')->middleware('permission:Website Settings-update');
        });

        Route::group([
            'prefix' => 'sub-photo-gallery',
            'as' => 'sub-photo-gallery.',
        ], function () {
            Route::get('{photoGallery}/index', 'SubPhotoGalleryController@index')->name('index')->middleware('permission:Website Settings-read');
            Route::get('{photoGallery}/create', 'SubPhotoGalleryController@create')->name('create')->middleware('permission:Website Settings-create');
            Route::post('{photoGallery}/store', 'SubPhotoGalleryController@store')->name('store')->middleware('permission:Website Settings-create');
            Route::get('{photoGallery}/show', 'SubPhotoGalleryController@show')->name('show')->middleware('permission:Website Settings-read');
            Route::get('{subPhotoGallery}/edit', 'SubPhotoGalleryController@edit')->name('edit')->middleware('permission:Website Settings-update');
            Route::patch('{subPhotoGallery}/update', 'SubPhotoGalleryController@update')->name('update')->middleware('permission:Website Settings-update');
            Route::get('{subPhotoGallery}/delete', 'SubPhotoGalleryController@delete')->name('delete')->middleware('permission:Website Settings-delete');
        });

        Route::group([
            'prefix' => 'website-banner',
            'as' => 'website-banner.',
        ], function () {
            Route::any('create', 'WebsiteBannerController@create')->name('create')->middleware('permission:Website Settings-read');
            Route::post('', 'WebsiteBannerController@store')->name('store')->middleware('permission:Website Settings-create');
            Route::post('{banner}/update', 'WebsiteBannerController@update')->name('update')->middleware('permission:Website Settings-update');
            Route::delete('{banner}/destroy', 'WebsiteBannerController@destroy')->name('destroy')->middleware('permission:Website Settings-delete');
        });

        Route::group([
            'prefix' => 'website-pop',
            'as' => 'website-pop.',
        ], function () {
            Route::any('create', 'WebsitePopupController@create')->name('create')->middleware('permission:Website Settings-read');
            Route::post('', 'WebsitePopupController@store')->name('store')->middleware('permission:Website Settings-create');
            Route::post('{popup}/update', 'WebsitePopupController@update')->name('update')->middleware('permission:Website Settings-update');
            Route::delete('{popup}/destroy', 'WebsitePopupController@destroy')->name('destroy')->middleware('permission:Website Settings-delete');
        });

        Route::group([
            'prefix' => 'member-pop',
            'as' => 'member-pop.',
        ], function () {
            Route::any('create', 'MemberPopupController@create')->name('create')->middleware('permission:Website Settings-read');
            Route::post('', 'MemberPopupController@store')->name('store')->middleware('permission:Website Settings-create');
            Route::post('{popup}/update', 'MemberPopupController@update')->name('update')->middleware('permission:Website Settings-update');
            Route::delete('{popup}/destroy', 'MemberPopupController@destroy')->name('destroy')->middleware('permission:Website Settings-delete');
        });

        // Category
        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::get('create', 'CategoryController@create')->name('create');
            Route::get('{parent?}', 'CategoryController@index')->name('index');
            Route::post('', 'CategoryController@store')->name('store');
            Route::get('{category}/edit', 'CategoryController@edit')->name('edit');
            Route::post('{category}/update', 'CategoryController@update')->name('update');
            Route::get('{category}/change-status', 'CategoryController@changeStatus')->name('change-status');
            Route::post('sub-category', 'CategoryController@subCategory')->name('sub-category');
            Route::post('status-update', 'CategoryController@statusUpdate')->name('status-update');
            Route::get('{category}/destroy', 'CategoryController@destroy')->name('destroy');
        });

        // Products
        Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
            Route::get('', 'ProductController@index')->name('index');
            Route::get('create', 'ProductController@create')->name('create');
            Route::post('store', 'ProductController@store')->name('store');
            Route::get('{product}/edit', 'ProductController@edit')->name('edit');
            Route::post('{product}/update', 'ProductController@update')->name('update');
            Route::post('status-update', 'ProductController@statusUpdate')->name('status-update');
        });

        Route::group([
            'prefix' => 'orders',
            'as' => 'orders.',
        ], function () {
            Route::get('', 'OrderController@index')->name('index');
            Route::get('{order}/details', 'OrderController@details')->name('details');
            Route::post('{order}/statusUpdate', 'OrderController@statusUpdate')->name('status-update');
            Route::get('{order}/orderInvoice', 'InvoiceController@orderInvoice')->name('order.invoice');
            Route::post('status-update', 'OrderController@OrderStatusUpdate')->name('bulk-status-update');
            Route::post('{order}/address-update', 'OrderController@addressUpdate')->name('address-update');
            Route::patch('{order}/awb', 'OrderAWBController@update')->name('awb.update');
            Route::get('change/transaction/{order}', 'OrderController@editTransactionId')
                ->name('transaction.id.edit');
            Route::post('change/transaction/id', 'OrderController@updateTransactionId')
                ->name('update.transaction.id');

        });

        Route::group([
            'prefix' => 'trending-products',
            'as' => 'trending-products.',
        ], function () {
            Route::get('', 'TrendingProductController@index')->name('index');
            Route::post('delete', 'TrendingProductController@delete')->name('delete');
            Route::post('store', 'TrendingProductController@store')->name('store');
            Route::post('sequence-update', 'TrendingProductController@sequenceUpdate')
                ->name('sequence-update');
        });

        Route::group([
            'prefix' => 'category-sliders',
            'as' => 'category-sliders.',
        ], function () {
            Route::get('', 'CategorySliderController@index')->name('show');
            Route::post('store', 'CategorySliderController@store')->name('store');
            Route::post('update-status', 'CategorySliderController@updateStatus')->name('update-status');
            Route::post('{categorySlider}/destroy', 'CategorySliderController@delete')->name('destroy');
        });

        Route::group([
            'prefix' => 'settings',
            'as' => 'settings.',
        ], function () {
            Route::get('', 'SettingsController@index')->name('index')->middleware('permission:Website Settings-read');
            Route::patch('update', 'SettingsController@update')->name('update')->middleware('permission:Website Settings-update');
            Route::get('content', 'SettingsController@content')->name('content')->middleware('permission:Website Settings-read');
            Route::post('about-us', 'SettingsController@about')->name('about-us')->middleware('permission:Website Settings-read');
            Route::post('terms', 'SettingsController@terms')->name('terms')->middleware('permission:Website Settings-read');
            Route::post('privacy', 'SettingsController@privacyPolicy')->name('privacy')->middleware('permission:Website Settings-read');
            Route::post('vision-mission', 'SettingsController@visionMission')->name('vision-mission')->middleware('permission:Website Settings-read');
            Route::post('founder-message', 'SettingsController@founderMessage')->name('founder-message')->middleware('permission:Website Settings-read');
            Route::any('contact-info', 'SettingsController@contactInfo')->name('contact-info')->middleware('permission:Website Settings-read');
            Route::any('change-logo', 'SettingsController@changeLogo')->name('change-logo')->middleware('permission:Website Settings-read');
            Route::any('change-background', 'SettingsController@changeBackground')->name('change-background')->middleware('permission:Website Settings-read');
        });

        Route::group([
            'prefix' => 'faqs',
            'as' => 'faqs.',
        ], function () {
            Route::get('', 'FaqsController@index')->name('index')->middleware('permission:Website Settings-read');
            Route::get('create', 'FaqsController@create')->name('create')->middleware('permission:Website Settings-create');
            Route::post('store', 'FaqsController@store')->name('store')->middleware('permission:Website Settings-create');
            Route::get('{faq}/edit', 'FaqsController@edit')->name('edit')->middleware('permission:Website Settings-update');
            Route::any('{faq}/update', 'FaqsController@update')->name('update')->middleware('permission:Website Settings-update');
        });

        Route::group([
            'prefix' => 'news',
            'as' => 'news.',
        ], function () {
            Route::get('', 'NewsController@index')->name('index')->middleware('permission:Website Settings-read');
            Route::get('create', 'NewsController@create')->name('create')->middleware('permission:Website Settings-create');
            Route::post('store', 'NewsController@store')->name('store')->middleware('permission:Website Settings-create');
            Route::get('{news}/edit', 'NewsController@edit')->name('edit')->middleware('permission:Website Settings-update');
            Route::post('{news}/update', 'NewsController@update')->name('update')->middleware('permission:Website Settings-update');
        });

        Route::group([
            'prefix' => 'business-plan',
            'as' => 'business-plan.',
        ], function () {
            Route::any('', 'BusinessPlanController@show')->name('show')->middleware('permission:Website Settings-read');
        });

        Route::any('direct-seller-contract', 'DashboardController@directSellerContract')->name('direct-seller-contract');

        Route::group([
            'prefix' => 'app-settings',
            'as' => 'app-settings.',
        ], function () {
            Route::get('', 'AppSettingsController@show')->name('show');
            Route::post('update', 'AppSettingsController@appSettingUpdate')->name('update');
            Route::post('apk-upload', 'AppSettingsController@apkUpload')->name('apk-upload');
        });

        Route::group([
            'prefix' => 'fund-wallet-transactions',
            'as' => 'fund-wallet-transactions.',
        ], function () {
            Route::get('', 'FundWalletTransactionController@index')->name('index')->middleware('permission:Fund Wallet-read');
            Route::get('create', 'FundWalletTransactionController@create')->name('create')->middleware('permission:Fund Wallet-create');
            Route::post('', 'FundWalletTransactionController@store')->name('store')->middleware('permission:Fund Wallet-create');
            Route::get('transfer', 'FundWalletTransactionController@transfer')->name('transfer')->middleware('permission:Fund Wallet-read');
        });

        Route::group([
            'prefix' => 'fund-requests',
            'as' => 'fund-requests.',
        ], function () {
            Route::get('', 'FundRequestController@index')->name('index')->middleware('permission:Fund Wallet-read');
            Route::get('approve/{fundRequest}', 'FundRequestController@approve')->name('approve')->middleware('permission:Fund Wallet-update');
            Route::post('reject/{fundRequest}', 'FundRequestController@reject')->name('reject')->middleware('permission:Fund Wallet-update');
        });

        Route::group([
            'prefix' => 'incomes',
            'as' => 'incomes.',
        ], function () {
            Route::get('referral-bonus-income', 'IncomeController@referralBonusIncome')->name('referral-bonus-income')->middleware('permission:Incomes-read');
            Route::get('team-bonus-income', 'IncomeController@teamBonusIncome')->name('team-bonus-income')->middleware('permission:Incomes-read');
            Route::get('reward-bonus-income', 'IncomeController@rewardBonusIncome')->name('reward-bonus-income')->middleware('permission:Incomes-read');
            Route::get('magic-pool-bonus-income', 'IncomeController@magicPoolBonusIncome')->name('magic-pool-bonus-income')->middleware('permission:Incomes-read');
        });

        Route::group([
            'prefix' => 'reward-bonus',
            'as' => 'reward-bonus.',
        ], function () {
            Route::get('', 'RewardBonusController@index')->name('index')->middleware('permission:Reward Bonus-read');
            Route::get('edit/{rewardBonus}', 'RewardBonusController@edit')->name('edit')->middleware('permission:Reward Bonus-update');
            Route::post('update/{rewardBonus}', 'RewardBonusController@update')->name('update')->middleware('permission:Reward Bonus-update');
        });

        Route::group([
            'prefix' => 'video',
            'as' => 'video.',
        ], function () {
            Route::get('', 'VideoController@index')->name('index')->middleware('permission:Website Settings-read');
            Route::get('create', 'VideoController@create')->name('create')->middleware('permission:Website Settings-create');
            Route::post('store', 'VideoController@store')->name('store')->middleware('permission:Website Settings-create');
            Route::get('{video}/edit', 'VideoController@edit')->name('edit')->middleware('permission:Website Settings-update');
            Route::post('{video}/update', 'VideoController@update')->name('update')->middleware('permission:Website Settings-update');
            Route::post('status-update', 'VideoController@statusUpdate')->name('status-update')->middleware('permission:Website Settings-update');
        });

    });
});
