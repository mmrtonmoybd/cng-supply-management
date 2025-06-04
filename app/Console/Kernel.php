<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CheckVehicleDocumentExpiry::class,
        Commands\NotifyInactiveLoads::class,
        Commands\NotifyNewLoad::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Run daily at 9:00 AM
        $schedule->command('vehicle:check-documents')
            ->dailyAt('09:00')
            ->appendOutputTo(storage_path('logs/vehicle-documents-check.log'));

        // Check for inactive loads every hour
        $schedule->command('loads:check-inactive')
            ->hourly()
            ->appendOutputTo(storage_path('logs/inactive-loads-check.log'));

        // Check for new loads every 2 minutes
        $schedule->command('loads:notify-new')
            ->everyTwoMinutes()
            ->appendOutputTo(storage_path('logs/new-loads-notification.log'));

        // Optimize the application daily at 8:00 AM
        $schedule->command('optimize')
            ->dailyAt('08:00')
            ->appendOutputTo(storage_path('logs/optimize.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
