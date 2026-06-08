<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;

class UpdateExpiredReservations extends Command
{
    // El nombre del comando que se ejecutará en la consola
    protected $signature = 'reservations:update-status';

    // Descripción del comando
    protected $description = 'Cambia el estado a "usada" de las reservas cuya fecha de fin ya pasó.';

    public function handle()
    {
        $ahora = Carbon::now();

        // Buscamos registros donde end_time sea menor que 'ahora' y sigan 'reservado'
        $afectados = Reservation::where('end_time', '<', $ahora)
            ->where('status', 'reservado')
            ->update(['status' => 'usada']);

        $this->info("Se han actualizado {$afectados} reservas al estado 'usada'.");
    }
}
