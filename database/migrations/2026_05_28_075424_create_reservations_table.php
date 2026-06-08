<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        // Relación con el usuario (quién reserva)
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        // Relación con el recurso (qué reserva)
        $table->foreignId('resource_id')->constrained()->cascadeOnDelete();

        // Fechas y horas de la reserva
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
