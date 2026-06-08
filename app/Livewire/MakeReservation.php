<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resource;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MakeReservation extends Component
{
    // Variables que se conectarán con el formulario HTML
    public $resource_id = '';
    public $start_time = '';
    public $end_time = '';

    // Mensajes de éxito o error locales
    public $errorMessage = '';
    public $successMessage = '';

    // Reglas de validación básicas
    protected $rules = [
        'resource_id' => 'required|exists:resources,id',
        'start_time' => 'required|date|after:now',
        'end_time' => 'required|date|after:start_time',
    ];

    public function createReservation()
    {
        $this->validate();
        $this->errorMessage = '';
        $this->successMessage = '';

        // 1. Verificar si el espacio ya está ocupado en ese rango de tiempo
        $isOccupied = Reservation::where('resource_id', $this->resource_id)
            ->where(function ($query) {
                $query->where('start_time', '<', $this->end_time)
                      ->where('end_time', '>', $this->start_time)
                      ->where('status', 'reservado'); // Solo consideramos las reservas activas
            })
            ->exists();

        if ($isOccupied) {
            $this->errorMessage = 'Lo sentimos, este espacio ya está reservado en el horario seleccionado.';
            return;
        }

        // 2. Si está libre, guardamos la reserva asociada al usuario autenticado
        Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $this->resource_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        $this->successMessage = '¡Reserva realizada con éxito!';

        // Limpiar el formulario
        $this->reset(['resource_id', 'start_time', 'end_time']);
    }

    public function render()
    {
        return view('livewire.make-reservation', [
            // Pasamos la lista de recursos creados por el Seeder para el desplegable del formulario
            'resources' => Resource::all(),
            // Pasamos las reservas actuales del usuario para listarlas abajo
            'myReservations' => Reservation::where('user_id', Auth::id())->where('start_time', '>', now())->with('resource')->latest()->get(),

            'myReservationsOld' => Reservation::where('user_id', Auth::id())->where('end_time', '<', now())->with('resource')->latest()->get()
        ]);
    }

    public function cancelReservation($reservationId)
    {
        // Buscamos la reserva que pertenezca al usuario actual para que nadie pueda borrar la reserva de otro
        $reservation = Reservation::where('user_id', Auth::id())->where('status', 'reservado')->find($reservationId);
        Log::info('Datos de la consulta de reservas:', $reservation->toArray());

        if ($reservation) {
            $reservation->update(['status' => 'cancelado']);
            Log::info('Datos de la consulta de reservas:', $reservation->toArray());
            $this->successMessage = 'La reserva ha sido cancelada correctamente.';
        }
    }
}
