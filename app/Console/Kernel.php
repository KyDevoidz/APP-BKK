<?php

namespace App\Console;

use App\Console\Commands\UpdateInternshipStatus;  // Add the custom command
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the internship status update command to run once a day at midnight
        $schedule->command('internship:update-status')->daily();  // Or use ->dailyAt('00:00') for specific time
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Automatically load commands in the Commands directory
        $this->load(__DIR__ . '/Commands');

        // Include the routes/console.php file where other console routes may be defined
        require base_path('routes/console.php');
    }
}