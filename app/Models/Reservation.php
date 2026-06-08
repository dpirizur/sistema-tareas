<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    // Añadimos las columnas autorizadas para asignación masiva
    protected $fillable = [
        'user_id',
        'resource_id',
        'status',
        'start_time',
        'end_time'
    ];

    /**
     * Relación: Una reserva pertenece a un Usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Una reserva pertenece a un Recurso (Espacio).
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }
}
