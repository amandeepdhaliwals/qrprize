<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // Backup Cleanup
        $schedule->command('backup:clean')->daily()->at('01:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
         // Custom Artisan command to generate referral codes
        Artisan::command('generate:referral-codes', function () {
            \App\Models\User::whereNull('referral_code')->each(function ($user) {
                $user->generateReferralCode();
            });
            $this->info('Referral codes generated successfully!');
        });

        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
