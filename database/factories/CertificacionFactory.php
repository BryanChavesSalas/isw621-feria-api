<?php

namespace Database\Factories;

use App\Enums\TipoDeCertificacion;
use App\Models\Certificacion;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Certificacion>
 */
class CertificacionFactory extends Factory
{
    /**
     * Datos ficticios de una certificación de un puesto nuevo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'nombre' => fake()->unique()->bothify('?????-###'),
            'vigencia_meses' => fake()->numberBetween(1, 36),
            'tipo' => fake()->randomElement(TipoDeCertificacion::cases()),
            'verificada' => true,
        ];
    }

    /** Estado: verificada en falso. */
    public function sinVerificar(): static
    {
        return $this->state(['verificada' => false]);
    }
}

