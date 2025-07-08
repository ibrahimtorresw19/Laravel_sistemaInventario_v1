<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define los comandos de la aplicación.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define el plan de ejecución de comandos.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Limpieza de sesiones expiradas cada hora
        $schedule->command('sessions:clean')
                 ->hourly()
                 ->appendOutputTo(storage_path('logs/session_clean.log'));

        // Opcional: Limpiar también caché de sesiones diariamente
        $schedule->command('session:gc')
                 ->daily();
    }
}
