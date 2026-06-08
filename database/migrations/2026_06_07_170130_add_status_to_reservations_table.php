<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Se crea el enum con las tres opciones permitidas
            $table->enum('status', ['reservado', 'cancelado', 'usada'])
                  ->default('reservado')
                  ->after('start_time'); // Lo ubica visualmente después de tu campo de fecha
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
