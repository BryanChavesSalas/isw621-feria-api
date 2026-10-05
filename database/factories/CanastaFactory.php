<?php

namespace Database\Factories;

use App\Enums\TamanoDeCanasta;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

class CanastaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'nombre' => fake()->unique()->words(2, true),
            'tamano' => fake()->randomElement(TamanoDeCanasta::cases()),
            'precio_colones' => fake()->numberBetween(1000, 100000),
            'disponible' => true,
        ];
    }
}
