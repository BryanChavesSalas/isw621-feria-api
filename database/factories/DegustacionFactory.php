<?php

namespace Database\Factories;

use App\Enums\Jornada;
use App\Models\Degustacion;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Degustacion>
 */
class DegustacionFactory extends Factory
{
    /**
     * Datos ficticios de una degustación de un puesto nuevo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'nombre' => fake()->unique()->bothify('?????-###'),
            'porciones' => fake()->numberBetween(10, 300),
            'jornada' => fake()->randomElement(Jornada::cases()),
            'activa' => true,
        ];
    }

    /** Estado: activa en falso. */
    public function inactiva(): static
    {
        return $this->state(['activa' => false]);
    }
}
