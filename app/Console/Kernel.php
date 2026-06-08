<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Los comandos de Artisan proporcionados por tu aplicación.
     *
     * @var array
     */
    protected $commands = [
        // 1. Registramos la clase del comando que creaste
        \App\Console\Commands\UpdateExpiredReservations::class,
    ];

    /**
     * Define la programación de comandos de la aplicación.
     */
    protected function schedule(Schedule $schedule): void
    {
        // 2. Programamos el comando usando su firma (signature)
        $schedule->command('reservations:update-status')->everyFiveMinutes();

        // Alternativa usando directamente la clase:
        // $schedule->command(\App\Console\Commands\UpdateExpiredReservations::class)->everyFiveMinutes();
    }

    /**
     * Registra los comandos basados en clausuras y/o carga las rutas de la consola.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
