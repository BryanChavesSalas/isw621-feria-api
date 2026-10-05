<?php

namespace Database\Factories;

use App\Enums\Canal;
use App\Models\Puesto;
use App\Models\Resena;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Resena>
 */
class ResenaFactory extends Factory
{
    /**
     * Datos ficticios de una reseña de un puesto nuevo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'autor' => fake()->unique()->bothify('?????-###'),
            'calificacion' => fake()->numberBetween(1, 5),
            'canal' => fake()->randomElement(Canal::cases()),
            'visible' => true,
        ];
    }

    /** Estado: visible en falso. */
    public function oculta(): static
    {
        return $this->state(['visible' => false]);
    }
}
