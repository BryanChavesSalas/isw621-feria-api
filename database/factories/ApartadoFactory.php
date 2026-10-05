<?php

namespace Database\Factories;

use App\Enums\FranjaDeEntrega;
use App\Models\Apartado;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Apartado>
 */
class ApartadoFactory extends Factory
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
            'cliente' => fake()->unique()->bothify('?????-###'),
            'cantidad' => fake()->numberBetween(1, 50),
            'entrega' => fake()->randomElement(FranjaDeEntrega::cases()),
            'confirmado' => true,
        ];
    }

    /** Estado: activa en falso. */
    public function sinConfirmar(): static
    {
        return $this->state(['confirmado' => false]);
    }
}
