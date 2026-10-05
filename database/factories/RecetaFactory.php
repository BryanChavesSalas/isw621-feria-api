<?php

namespace Database\Factories;

use App\Enums\Dificultad;
use App\Models\Puesto;
use App\Models\Receta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Receta>
 */
class RecetaFactory extends Factory
{
    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'titulo' => fake()->unique()->bothify('?????-###'),
            'minutos' => fake()->numberBetween(5, 240),
            'dificultad' => fake()->randomElement(Dificultad::cases()),
            'publicada' => true,
        ];
    }

    /** Estado: publicada en falso. */
    public function sinPublicar(): static
    {
        return $this->state(['publicada' => false]);
    }
}
