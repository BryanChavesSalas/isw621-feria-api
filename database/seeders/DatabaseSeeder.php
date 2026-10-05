<?php

namespace Database\Seeders;

use App\Enums\Jornada;
use App\Models\Puesto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** Tres puestos ficticios de la feria y las degustaciones del ejemplo. Se puede correr varias veces. */
    public function run(): void
    {
        $quesos = Puesto::query()->updateOrCreate(['nombre' => 'Quesos Don Rafael'], ['telefono' => '8000-0001']);
        $verduras = Puesto::query()->updateOrCreate(['nombre' => 'Verduras Doña Marielos'], ['telefono' => '8000-0002']);
        Puesto::query()->updateOrCreate(['nombre' => 'Frutas El Guayabo'], ['telefono' => '8000-0003']);

        $degustaciones = [
            [$quesos, 'Queso tierno', 120, Jornada::Manana, true],
            [$quesos, 'Natilla', 80, Jornada::Tarde, true],
            [$verduras, 'Picadillo de chayote', 60, Jornada::Manana, false],
        ];

        foreach ($degustaciones as [$puesto, $nombre, $porciones, $jornada, $activa]) {
            $puesto->degustaciones()->updateOrCreate(
                ['nombre' => $nombre],
                ['porciones' => $porciones, 'jornada' => $jornada, 'activa' => $activa],
            );
        }
    }
}
