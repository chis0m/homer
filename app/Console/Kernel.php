<?php

namespace App\Console;

use App\Console\Commands\Test;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Property\Console\Commands\Expiry;

;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) :void
    {
        $schedule->command('telescope:prune --hours=48')->daily();
        $schedule->command(Expiry::class)->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() :void
    {
        $this->load(__DIR__.'/Commands');
        $this->load(__DIR__.'/../../modules/Property/Console/Commands');

        require base_path('routes/console.php');
    }
}
