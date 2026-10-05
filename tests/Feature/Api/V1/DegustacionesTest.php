<?php

namespace Tests\Feature\Api\V1;

use App\Models\Degustacion;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DegustacionesTest extends TestCase
{
    use RefreshDatabase;

    /** El listado trae solo las degustaciones activas, ordenadas por nombre (A a Z), y nada de otros puestos. */
    #[Test]
    public function lista_solo_activas_del_puesto_en_orden(): void
    {
        $puesto = Puesto::factory()->create();
        Degustacion::factory()->for($puesto)->create(['nombre' => 'Queso tierno', 'porciones' => 10]);
        Degustacion::factory()->for($puesto)->create(['nombre' => 'Natilla', 'porciones' => 300]);
        Degustacion::factory()->for($puesto)->inactiva()->create(['nombre' => 'Rosquillas']);
        Degustacion::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/degustaciones")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.nombre', 'Natilla')
            ->assertJsonPath('data.1.nombre', 'Queso tierno');
    }

    /** Crear responde 201, devuelve el recurso y dice dónde quedó en Location. */
    #[Test]
    public function crea_con_201_y_la_direccion_en_location(): void
    {
        $puesto = Puesto::factory()->create();

        $respuesta = $this->postJson("/api/v1/puestos/{$puesto->id}/degustaciones", [
            'nombre' => 'Queso tierno',
            'porciones' => 300,
            'jornada' => 'manana',
        ]);

        $id = $respuesta->assertCreated()
            ->assertJsonPath('data.nombre', 'Queso tierno')
            ->assertJsonPath('data.activa', true)
            ->json('data.id');
        $respuesta->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/degustaciones/{$id}"));
        $this->assertDatabaseHas('degustaciones', ['id' => $id, 'puesto_id' => $puesto->id]);
    }

    /** Los datos inválidos responden 422 en formato RFC 9457, con el error de cada campo. */
    #[Test]
    public function rechaza_datos_invalidos_con_422(): void
    {
        $puesto = Puesto::factory()->create();

        $this->postJson("/api/v1/puestos/{$puesto->id}/degustaciones", [
            'nombre' => str_repeat('x', 61),
            'porciones' => 301,
            'jornada' => 'otro',
        ])
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['nombre', 'porciones', 'jornada']);
    }

    /** Pedir una degustación con el identificador de otro puesto responde 404. */
    #[Test]
    public function responde_404_si_es_de_otro_puesto(): void
    {
        $puesto = Puesto::factory()->create();
        $ajena = Degustacion::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/degustaciones/{$ajena->id}")
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }

    /** PATCH cambia solo lo que llega; cambiar de puesto está prohibido. */
    #[Test]
    public function patch_cambia_solo_lo_enviado_y_prohibe_cambiar_el_puesto(): void
    {
        $degustacion = Degustacion::factory()->create(['nombre' => 'Queso tierno', 'porciones' => 10]);
        $ruta = "/api/v1/puestos/{$degustacion->puesto_id}/degustaciones/{$degustacion->id}";

        $this->patchJson($ruta, ['porciones' => 300])
            ->assertOk()
            ->assertJsonPath('data.porciones', 300)
            ->assertJsonPath('data.nombre', 'Queso tierno');

        $this->patchJson($ruta, ['puesto_id' => Puesto::factory()->create()->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['puesto_id']);
    }

    /** Eliminar responde 204 sin cuerpo y borra la fila. */
    #[Test]
    public function elimina_con_204(): void
    {
        $degustacion = Degustacion::factory()->create();

        $this->deleteJson("/api/v1/puestos/{$degustacion->puesto_id}/degustaciones/{$degustacion->id}")
            ->assertNoContent();
        $this->assertDatabaseMissing('degustaciones', ['id' => $degustacion->id]);
    }
}
