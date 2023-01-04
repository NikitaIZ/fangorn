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
        Commands\ConnectionTask::class,
        Commands\DolarTask::class,
        Commands\RoomTask::class,
        Commands\XmlHistoryTask::class,
        Commands\XmlForecastTask::class,
        Commands\XmlForecastTextTask::class,
        Commands\Dinners::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->exec("cmd /c E:\\fangorn\connection.bat");
        $schedule->command('xml:task');
        $schedule->exec("cmd /c E:\\fangorn\disconnection.bat");*/

        //$schedule->command('room:task');
        $schedule->command('history:task');
        //$schedule->command('forecast:task');
        $schedule->command('forecastext:task');
        $schedule->command('dinner:task');
        //$schedule->command('dolar:task')->timezone('America/Caracas')->between('00:00', '00:30');
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
