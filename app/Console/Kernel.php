<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('subscriptions:check')->hourly();
        // $schedule->command('plisio:rates')->hourly();
        // $schedule->command('plisio:update-withdrawals')->everyMinute();
        $schedule->command('passimpay:rates')->hourly();
        $schedule->command('passimpay:update-withdrawals')->everyFiveMinutes();
        $schedule->command('balances:auto-credit-money')->daily();
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
