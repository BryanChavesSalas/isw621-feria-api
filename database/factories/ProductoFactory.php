<?php

namespace Database\Factories;

use App\Enums\Unidad;
use App\Models\Producto;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Datos ficticios de un producto de un puesto nuevo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puesto_id' => Puesto::factory(),
            'nombre' => fake()->unique()->bothify('?????-###'),
            'precio_colones' => fake()->numberBetween(50, 200000),
            'unidad' => fake()->randomElement(Unidad::cases()),
            'disponible' => true,
        ];
    }

    /** Estado: disponible en falso. */
    public function noDisponible(): static
    {
        return $this->state(['disponible' => false]);
    }
}
