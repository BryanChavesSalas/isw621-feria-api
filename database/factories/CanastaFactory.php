<?php

namespace Database\Factories;

use App\Enums\TamanoDeCanasta;
use App\Models\Canasta;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Canasta>
 */
class CanastaFactory extends Factory
{
    /**
     * Estado por defecto de una canasta.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'nombre' => fake()->unique()->bothify('?????-###'),
            'precio_colones' => fake()->numberBetween(1000, 100000),
            'tamano' => fake()->randomElement(TamanoDeCanasta::cases()),
            'disponible' => true,
        ];
    }

    /** Estado: disponible en falso. */
    public function noDisponible(): static
    {
        return $this->state(['disponible' => false]);
    }
}
