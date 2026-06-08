<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creamos 3 recursos de prueba en la base de datos
        Resource::create([
            'name' => 'Sala de Juntas Premium',
            'description' => 'Equipada con proyector, pantalla 4K y aire acondicionado.',
            'capacity' => 10,
        ]);

        Resource::create([
            'name' => 'Escritorio Hot Desk A',
            'description' => 'Espacio individual en zona común con conexión ethernet.',
            'capacity' => 1,
        ]);

        Resource::create([
            'name' => 'Cabina para Videollamadas (Zoom Room)',
            'description' => 'Espacio insonorizado ideal para llamadas privadas.',
            'capacity' => 1,
        ]);
    }
}
