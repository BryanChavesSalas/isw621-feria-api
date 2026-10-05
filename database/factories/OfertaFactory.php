<?php

namespace Database\Factories;

use App\Enums\TipoDeOferta;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfertaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'titulo' => fake()->sentence(3),
            'descuento_porcentaje' => fake()->numberBetween(5, 50),
            'tipo' => fake()->randomElement(TipoDeOferta::cases()),
            'vigente' => fake()->boolean(80),
        ];
    }
}