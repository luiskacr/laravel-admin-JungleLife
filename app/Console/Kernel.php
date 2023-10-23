<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Set Timezone to Costa Rica
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone(): \DateTimeZone|string|null
    {
        return 'America/Costa_Rica';
    }

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule):void
    {
        $schedule->command(\Spatie\Health\Commands\RunHealthChecksCommand::class)->hourly();

        if(app()->environment('production')){
            $schedule->command('exchange-rate:get')->dailyAt('1:00');
            $schedule->command('tours:create')->dailyAt('1:00');
            $schedule->command('tours:close')->hourlyAt(15);
        }else{
            $schedule->command('exchange-rate:get')->everyMinute();
            $schedule->command('tours:create')->everyMinute();
            $schedule->command('tours:close')->everyMinute();
        }
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
