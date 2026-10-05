<?php

namespace Tests\Feature\Api\V1;

use App\Models\Canasta;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CanastasTest extends TestCase
{
    use RefreshDatabase;

    /** El listado trae solo las canastas disponibles, de la más barata a la más cara, y nada de otros puestos. */
    #[Test]
    public function lista_solo_disponibles_del_puesto_en_orden(): void
    {
        $puesto = Puesto::factory()->create();
        Canasta::factory()->for($puesto)->create(['nombre' => 'Canasta de frutas', 'precio_colones' => 100000]);
        Canasta::factory()->for($puesto)->create(['nombre' => 'Canasta de verduras', 'precio_colones' => 1000]);
        Canasta::factory()->for($puesto)->noDisponible()->create(['nombre' => 'Canasta familiar']);
        Canasta::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/canastas")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.nombre', 'Canasta de verduras')
            ->assertJsonPath('data.1.nombre', 'Canasta de frutas');
    }

    /** Crear una canasta responde 201 con su dirección en Location. */
    #[Test]
    public function crea_con_201_y_la_direccion_en_location(): void
    {
        $puesto = Puesto::factory()->create();

        $respuesta = $this->postJson("/api/v1/puestos/{$puesto->id}/canastas", [
            'nombre' => 'Canasta de frutas',
            'precio_colones' => 100000,
            'tamano' => 'pequena',
        ])
            ->assertCreated()
            ->assertJsonPath('data.disponible', true);

        $id = $respuesta->json('data.id');
        $respuesta->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/canastas/{$id}"));
    }

    /** Datos fuera de las reglas responden 422 con errores por campo. */
    #[Test]
    public function rechaza_datos_invalidos_con_422(): void
    {
        $puesto = Puesto::factory()->create();

        $this->postJson("/api/v1/puestos/{$puesto->id}/canastas", [
            'nombre' => str_repeat('x', 61),
            'precio_colones' => 100001,
            'tamano' => 'otro',
        ])
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['nombre', 'precio_colones', 'tamano']);
    }

    /** Pedir una canasta con el identificador de otro puesto responde 404. */
    #[Test]
    public function responde_404_si_es_de_otro_puesto(): void
    {
        $puesto = Puesto::factory()->create();
        $ajena = Canasta::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/canastas/{$ajena->id}")
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }

    /** PATCH cambia solo lo enviado y no deja cambiar el puesto. */
    #[Test]
    public function patch_cambia_solo_lo_enviado_y_prohibe_cambiar_el_puesto(): void
    {
        $canasta = Canasta::factory()->create(['precio_colones' => 1000]);
        $url = "/api/v1/puestos/{$canasta->puesto_id}/canastas/{$canasta->id}";

        $this->patchJson($url, ['precio_colones' => 100000])
            ->assertOk()
            ->assertJsonPath('data.precio_colones', 100000)
            ->assertJsonPath('data.nombre', $canasta->nombre);

        $this->patchJson($url, ['puesto_id' => 999])
            ->assertUnprocessable();
    }

    /** Eliminar responde 204 sin cuerpo y la fila desaparece. */
    #[Test]
    public function elimina_con_204(): void
    {
        $canasta = Canasta::factory()->create();

        $this->deleteJson("/api/v1/puestos/{$canasta->puesto_id}/canastas/{$canasta->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('canastas', ['id' => $canasta->id]);
    }
}
