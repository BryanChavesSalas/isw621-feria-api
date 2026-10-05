<?php

namespace Tests\Feature\Api\V1;

use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PuestosTest extends TestCase
{
    use RefreshDatabase;

    /** El listado de puestos sale ordenado por nombre. */
    #[Test]
    public function lista_los_puestos_por_nombre(): void
    {
        Puesto::factory()->create(['nombre' => 'Verduras']);
        Puesto::factory()->create(['nombre' => 'Frutas']);

        $this->getJson('/api/v1/puestos')
            ->assertOk()
            ->assertJsonPath('data.0.nombre', 'Frutas')
            ->assertJsonPath('data.1.nombre', 'Verduras');
    }

    /** Un puesto que no existe responde 404 en formato RFC 9457. */
    #[Test]
    public function un_puesto_inexistente_responde_404(): void
    {
        $this->getJson('/api/v1/puestos/999')
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }
}
