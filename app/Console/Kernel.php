<?php

namespace App\Console;

use App\Jobs\Admin\GeneratePayout;
use App\Models\Export;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new GeneratePayout())->weeklyOn(2, '23:59');

        $schedule->call(function () {
            Export::expired()->eachById(function (Export $export) {
                $export->delete();
            });
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
