<?php

namespace Database\Factories;

use App\Enums\CategoriaDeAviso;
use App\Models\Aviso;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Aviso>
 */
class AvisoFactory extends Factory
{
    /**
     * Datos ficticios de un aviso de un puesto nuevo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'titulo' => fake()->unique()->bothify('?????-###'),
            'dias_vigencia' => fake()->numberBetween(1, 30),
            'categoria' => fake()->randomElement(CategoriaDeAviso::cases()),
            'activo' => true,
        ];
    }

    /** Estado: activo en falso. */
    public function inactivo(): static
    {
        return $this->state(['activo' => false]);
    }
}
