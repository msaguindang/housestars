<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\Referral;
use App\Console\Commands\EndingSubscription;
use App\Console\Commands\PositionAvailabilityCount;
use App\Console\Commands\UserMetaMultipleCategoriesChange;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Referral::class,
        EndingSubscription::class,
        PositionAvailabilityCount::class,
        UserMetaMultipleCategoriesChange::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:referral')
                  ->everyMinute();

        $schedule->command('housestars:check-subscriptions')
                  ->everyMinute();
        
        $schedule->command('command:position-availability-count')
                  ->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
