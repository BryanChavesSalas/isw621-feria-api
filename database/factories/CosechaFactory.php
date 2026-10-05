<?php

namespace Database\Factories;

use App\Enums\Temporada;
use App\Models\Cosecha;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cosecha>
 */
class CosechaFactory extends Factory
{
    /**
     * Datos ficticios de una cosecha de un puesto nuevo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'cultivo' => fake()->unique()->bothify('?????-###'),
            'kilos_estimados' => fake()->numberBetween(1, 5000),
            'temporada' => fake()->randomElement(Temporada::cases()),
            'confirmada' => true,
        ];
    }

    /** Estado: confirmada en falso. */
    public function sinConfirmar(): static
    {
        return $this->state(['confirmada' => false]);
    }
}
