<?php

namespace Database\Factories;

use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Puesto>
 */
class PuestoFactory extends Factory
{
    /**
     * Puesto ficticio de la feria.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => 'Puesto '.fake()->unique()->numerify('###'),
            'telefono' => fake()->numerify('8###-####'),
        ];
    }
}
