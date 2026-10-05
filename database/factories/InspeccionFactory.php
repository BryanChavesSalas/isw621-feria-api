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
            'acta' => fake()->unique()->bothify('?????-###'),
            'puntaje' => fake()->numberBetween(0, 100),
            'resultado' => fake()->randomElement(ResultadoDeInspeccion::cases()),
            'publicada' => true,
        ];
    }

    /** Estado: publicada en falso. */
        public function sinPublicar(): static
        {
            return $this->state(['publicada' => false]);
        }
}
