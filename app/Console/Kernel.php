<?php

namespace Consensus\Console;

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
        Commands\Import::class,
        Commands\Notificaciones::class,
        Commands\TareaNotificacionAsignado::class,
        Commands\TareaNotificacionAsignadoLista::class,
        Commands\Prueba::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tarea:notif')->dailyAt('01:00');
        $schedule->command('tarea:abogado')->dailyAt('02:00');
    }
}
