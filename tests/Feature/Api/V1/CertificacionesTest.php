<?php

namespace Tests\Feature\Api\V1;

use App\Models\Certificacion;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CertificacionesTest extends TestCase
{
    use RefreshDatabase;

    /** El listado trae solo las certificaciones verificadas, ordenadas por nombre (A a Z), y nada de otros puestos. */
    #[Test]
    public function lista_solo_verificadas_del_puesto_en_orden(): void
    {
        $puesto = Puesto::factory()->create();
        Certificacion::factory()->for($puesto)->create(['nombre' => 'Buenas prácticas', 'vigencia_meses' => 1]);
        Certificacion::factory()->for($puesto)->create(['nombre' => 'Finca orgánica', 'vigencia_meses' => 36]);
        Certificacion::factory()->for($puesto)->sinVerificar()->create(['nombre' => 'Comercio justo']);
        Certificacion::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/certificaciones")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.nombre', 'Buenas prácticas')
            ->assertJsonPath('data.1.nombre', 'Finca orgánica');
    }

    /** Crear responde 201, devuelve el recurso y dice dónde quedó en Location. */
    #[Test]
    public function crea_con_201_y_la_direccion_en_location(): void
    {
        $puesto = Puesto::factory()->create();

        $respuesta = $this->postJson("/api/v1/puestos/{$puesto->id}/certificaciones", [
            'nombre' => 'Buenas prácticas',
            'vigencia_meses' => 36,
            'tipo' => 'organico',
        ]);

        $id = $respuesta->assertCreated()
            ->assertJsonPath('data.nombre', 'Buenas prácticas')
            ->assertJsonPath('data.verificada', true)
            ->json('data.id');
        $respuesta->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/certificaciones/{$id}"));
        $this->assertDatabaseHas('certificaciones', ['id' => $id, 'puesto_id' => $puesto->id]);
    }

    /** Los datos inválidos responden 422 en formato RFC 9457, con el error de cada campo. */
    #[Test]
    public function rechaza_datos_invalidos_con_422(): void
    {
        $puesto = Puesto::factory()->create();

        $this->postJson("/api/v1/puestos/{$puesto->id}/certificaciones", [
            'nombre' => str_repeat('x', 81),
            'vigencia_meses' => 37,
            'tipo' => 'otro',
        ])
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['nombre', 'vigencia_meses', 'tipo']);
    }

    /** Pedir una certificación con el identificador de otro puesto responde 404. */
    #[Test]
    public function responde_404_si_es_de_otro_puesto(): void
    {
        $puesto = Puesto::factory()->create();
        $ajena = Certificacion::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/certificaciones/{$ajena->id}")
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }

    /** PATCH cambia solo lo que llega; cambiar de puesto está prohibido. */
    #[Test]
    public function patch_cambia_solo_lo_enviado_y_prohibe_cambiar_el_puesto(): void
    {
        $certificacion = Certificacion::factory()->create(['nombre' => 'Buenas prácticas', 'vigencia_meses' => 1]);
        $ruta = "/api/v1/puestos/{$certificacion->puesto_id}/certificaciones/{$certificacion->id}";

        $this->patchJson($ruta, ['vigencia_meses' => 36])
            ->assertOk()
            ->assertJsonPath('data.vigencia_meses', 36)
            ->assertJsonPath('data.nombre', 'Buenas prácticas');

        $this->patchJson($ruta, ['puesto_id' => Puesto::factory()->create()->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['puesto_id']);
    }

    /** Eliminar responde 204 sin cuerpo y borra la fila. */
    #[Test]
    public function elimina_con_204(): void
    {
        $certificacion = Certificacion::factory()->create();

        $this->deleteJson("/api/v1/puestos/{$certificacion->puesto_id}/certificaciones/{$certificacion->id}")
            ->assertNoContent();
        $this->assertDatabaseMissing('certificaciones', ['id' => $certificacion->id]);
    }
}
