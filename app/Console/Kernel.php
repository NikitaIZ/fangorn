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
        Commands\XmlTask::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* $schedule->exec("cmd /c E:\\fangorn\connection.bat");
        $schedule->command('xml:task');
        $schedule->exec("cmd /c E:\\fangorn\disconnection.bat");*/

        /*conectar*/
        $schedule->exec("cmd /c E:\\fangorn\connection.bat")->dailyAt('4:20');

        /*Chequear xml*/
        /*12:30am*/
        $schedule->command('xml:task')->dailyAt('4:30');
        $schedule->command('xml:task')->dailyAt('4:40');
        $schedule->command('xml:task')->dailyAt('4:50');

        /*1:00am*/
        $schedule->command('xml:task')->dailyAt('5:00');
        $schedule->command('xml:task')->dailyAt('5:10');
        $schedule->command('xml:task')->dailyAt('5:20');
        $schedule->command('xml:task')->dailyAt('5:30');
        $schedule->command('xml:task')->dailyAt('5:40');
        $schedule->command('xml:task')->dailyAt('5:50');

        /*2:00am*/
        $schedule->command('xml:task')->dailyAt('6:00');
        $schedule->command('xml:task')->dailyAt('6:10');
        $schedule->command('xml:task')->dailyAt('6:20');
        $schedule->command('xml:task')->dailyAt('6:30');
        $schedule->command('xml:task')->dailyAt('6:40');
        $schedule->command('xml:task')->dailyAt('6:50');

        /*3:00am*/
        $schedule->command('xml:task')->dailyAt('7:00');
        $schedule->command('xml:task')->dailyAt('7:10');
        $schedule->command('xml:task')->dailyAt('7:20');
        $schedule->command('xml:task')->dailyAt('7:30');
        $schedule->command('xml:task')->dailyAt('7:40');
        $schedule->command('xml:task')->dailyAt('7:50');

        /*4:00am*/
        $schedule->command('xml:task')->dailyAt('8:00');
        $schedule->command('xml:task')->dailyAt('8:10');
        $schedule->command('xml:task')->dailyAt('8:20');
        $schedule->command('xml:task')->dailyAt('8:30');
        $schedule->command('xml:task')->dailyAt('8:40');
        $schedule->command('xml:task')->dailyAt('8:50');

        /*5:00am*/
        $schedule->command('xml:task')->dailyAt('9:00');
        $schedule->command('xml:task')->dailyAt('9:10');
        $schedule->command('xml:task')->dailyAt('9:20');
        $schedule->command('xml:task')->dailyAt('9:30');
        $schedule->command('xml:task')->dailyAt('9:40');
        $schedule->command('xml:task')->dailyAt('9:50');

        /*6:00am*/
        $schedule->command('xml:task')->dailyAt('10:00');
        $schedule->command('xml:task')->dailyAt('10:10');
        $schedule->command('xml:task')->dailyAt('10:20');
        $schedule->command('xml:task')->dailyAt('10:30');
        $schedule->command('xml:task')->dailyAt('10:40');
        $schedule->command('xml:task')->dailyAt('10:50');

        /*7:00am*/
        $schedule->command('xml:task')->dailyAt('11:00');
        $schedule->command('xml:task')->dailyAt('11:10');
        $schedule->command('xml:task')->dailyAt('11:20');

        /*desconectar*/
        $schedule->exec("cmd /c E:\\fangorn\disconnection.bat")->dailyAt('11:30');
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
