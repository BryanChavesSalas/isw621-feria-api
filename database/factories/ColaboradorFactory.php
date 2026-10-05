<?php

namespace Database\Factories;

use App\Enums\RolDeColaborador;
use App\Models\Colaborador;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Colaborador>
 */
class ColaboradorFactory extends Factory
{
    /**
     * Datos ficticios de un colaborador de un puesto nuevo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'nombre' => fake()->unique()->bothify('?????-###'),
            'horas_semanales' => fake()->numberBetween(4, 48),
            'rol' => fake()->randomElement(RolDeColaborador::cases()),
            'activo' => true,
        ];
    }

    /** Estado: activo en falso. */
    public function inactivo(): static
    {
        return $this->state(['activo' => false]);
    }
}
