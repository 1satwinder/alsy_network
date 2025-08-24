<?php

namespace App\Providers;

use App\Library\Settings;
use App\Models\Export;
use App\Models\FundWalletTransaction;
use App\Models\KYC;
use App\Models\Member;
use App\Models\TopUp;
use App\Models\WalletTransaction;
use App\Observers\ExportObserver;
use App\Observers\FundWalletTransactionObserver;
use App\Observers\KYCObserver;
use App\Observers\MemberObserver;
use App\Observers\TopUpObserver;
use App\Observers\WalletTransactionObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        app()->singleton('settings', function ($app) {
            return new Settings();
        });

        Carbon::macro('timeFormat', function () {
            return $this->format('h:i A');
        });

        Carbon::macro('dateFormat', function () {
            return $this->format('d-m-Y');
        });

        Carbon::macro('dateTimeFormat', function () {
            return $this->format('d-m-Y h:i A');
        });

        Member::observe(MemberObserver::class);
        KYC::observe(KYCObserver::class);
        WalletTransaction::observe(WalletTransactionObserver::class);
        FundWalletTransaction::observe(FundWalletTransactionObserver::class);
        TopUp::observe(TopUpObserver::class);
        Export::observe(ExportObserver::class);
    }
}
