<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    // Permitimos que Laravel llene el título de forma masiva
    protected $fillable = ['title', 'is_completed'];

    /**
     * Relación: Una tarea pertenece a un Usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
