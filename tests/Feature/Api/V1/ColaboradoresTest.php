<?php

namespace Tests\Feature\Api\V1;

use App\Models\Colaborador;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ColaboradoresTest extends TestCase
{
    use RefreshDatabase;

    /** El listado trae solo los colaboradores activos, ordenados por nombre (A a Z), y nada de otros puestos. */
    #[Test]
    public function lista_solo_activos_del_puesto_en_orden(): void
    {
        $puesto = Puesto::factory()->create();
        Colaborador::factory()->for($puesto)->create(['nombre' => 'Bernardo', 'horas_semanales' => 4]);
        Colaborador::factory()->for($puesto)->create(['nombre' => 'Andrés', 'horas_semanales' => 48]);
        Colaborador::factory()->for($puesto)->inactivo()->create(['nombre' => 'Carmen']);
        Colaborador::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/colaboradores")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.nombre', 'Andrés')
            ->assertJsonPath('data.1.nombre', 'Bernardo');
    }

    /** Crear responde 201, devuelve el recurso y dice dónde quedó en Location. */
    #[Test]
    public function crea_con_201_y_la_direccion_en_location(): void
    {
        $puesto = Puesto::factory()->create();

        $respuesta = $this->postJson("/api/v1/puestos/{$puesto->id}/colaboradores", [
            'nombre' => 'Bernardo',
            'horas_semanales' => 48,
            'rol' => 'vendedor',
        ]);

        $id = $respuesta->assertCreated()
            ->assertJsonPath('data.nombre', 'Bernardo')
            ->assertJsonPath('data.activo', true)
            ->json('data.id');
        $respuesta->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/colaboradores/{$id}"));
        $this->assertDatabaseHas('colaboradores', ['id' => $id, 'puesto_id' => $puesto->id]);
    }

    /** Los datos inválidos responden 422 en formato RFC 9457, con el error de cada campo. */
    #[Test]
    public function rechaza_datos_invalidos_con_422(): void
    {
        $puesto = Puesto::factory()->create();

        $this->postJson("/api/v1/puestos/{$puesto->id}/colaboradores", [
            'nombre' => str_repeat('x', 61),
            'horas_semanales' => 49,
            'rol' => 'otro',
        ])
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['nombre', 'horas_semanales', 'rol']);
    }

    /** Pedir un colaborador con el identificador de otro puesto responde 404. */
    #[Test]
    public function responde_404_si_es_de_otro_puesto(): void
    {
        $puesto = Puesto::factory()->create();
        $ajeno = Colaborador::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/colaboradores/{$ajeno->id}")
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }

    /** PATCH cambia solo lo que llega; cambiar de puesto está prohibido. */
    #[Test]
    public function patch_cambia_solo_lo_enviado_y_prohibe_cambiar_el_puesto(): void
    {
        $colaborador = Colaborador::factory()->create(['nombre' => 'Bernardo', 'horas_semanales' => 4]);
        $ruta = "/api/v1/puestos/{$colaborador->puesto_id}/colaboradores/{$colaborador->id}";

        $this->patchJson($ruta, ['horas_semanales' => 48])
            ->assertOk()
            ->assertJsonPath('data.horas_semanales', 48)
            ->assertJsonPath('data.nombre', 'Bernardo');

        $this->patchJson($ruta, ['puesto_id' => Puesto::factory()->create()->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['puesto_id']);
    }

    /** Eliminar responde 204 sin cuerpo y borra la fila. */
    #[Test]
    public function elimina_con_204(): void
    {
        $colaborador = Colaborador::factory()->create();

        $this->deleteJson("/api/v1/puestos/{$colaborador->puesto_id}/colaboradores/{$colaborador->id}")
            ->assertNoContent();
        $this->assertDatabaseMissing('colaboradores', ['id' => $colaborador->id]);
    }
}
