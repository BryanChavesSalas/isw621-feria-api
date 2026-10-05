<?php

namespace Tests\Feature\Api\V1;

use App\Models\Aviso;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AvisosTest extends TestCase
{
    use RefreshDatabase;

    /** El listado trae solo los avisos activos, ordenados por título (A a Z), y nada de otros puestos. */
    #[Test]
    public function lista_solo_activos_del_puesto_en_orden(): void
    {
        $puesto = Puesto::factory()->create();
        Aviso::factory()->for($puesto)->create(['titulo' => 'Bajó el tomate', 'dias_vigencia' => 1]);
        Aviso::factory()->for($puesto)->create(['titulo' => 'Abrimos tarde', 'dias_vigencia' => 30]);
        Aviso::factory()->for($puesto)->inactivo()->create(['titulo' => 'Cerramos el domingo']);
        Aviso::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/avisos")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.titulo', 'Abrimos tarde')
            ->assertJsonPath('data.1.titulo', 'Bajó el tomate');
    }

    /** Crear responde 201, devuelve el recurso y dice dónde quedó en Location. */
    #[Test]
    public function crea_con_201_y_la_direccion_en_location(): void
    {
        $puesto = Puesto::factory()->create();

        $respuesta = $this->postJson("/api/v1/puestos/{$puesto->id}/avisos", [
            'titulo' => 'Bajó el tomate',
            'dias_vigencia' => 30,
            'categoria' => 'horario',
        ]);

        $id = $respuesta->assertCreated()
            ->assertJsonPath('data.activo', true)
            ->json('data.id');
        $respuesta->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/avisos/{$id}"));
        $this->assertDatabaseHas('avisos', ['id' => $id, 'puesto_id' => $puesto->id]);
    }

    /** Los datos inválidos responden 422 en formato RFC 9457, con el error de cada campo. */
    #[Test]
    public function rechaza_datos_invalidos_con_422(): void
    {
        $puesto = Puesto::factory()->create();

        $this->postJson("/api/v1/puestos/{$puesto->id}/avisos", [
            'titulo' => str_repeat('x', 81),
            'dias_vigencia' => 31,
            'categoria' => 'otro',
        ])
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['titulo', 'dias_vigencia', 'categoria']);
    }

    /** Pedir un aviso con el identificador de otro puesto responde 404. */
    #[Test]
    public function responde_404_si_es_de_otro_puesto(): void
    {
        $puesto = Puesto::factory()->create();
        $ajeno = Aviso::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/avisos/{$ajeno->id}")
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }

    /** PATCH cambia solo lo que llega; cambiar de puesto está prohibido. */
    #[Test]
    public function patch_cambia_solo_lo_enviado_y_prohibe_cambiar_el_puesto(): void
    {
        $aviso = Aviso::factory()->create(['titulo' => 'Bajó el tomate', 'dias_vigencia' => 1]);
        $ruta = "/api/v1/puestos/{$aviso->puesto_id}/avisos/{$aviso->id}";

        $this->patchJson($ruta, ['dias_vigencia' => 30])
            ->assertOk()
            ->assertJsonPath('data.dias_vigencia', 30)
            ->assertJsonPath('data.titulo', 'Bajó el tomate');

        $this->patchJson($ruta, ['puesto_id' => Puesto::factory()->create()->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['puesto_id']);
    }

    /** Eliminar responde 204 sin cuerpo y borra la fila. */
    #[Test]
    public function elimina_con_204(): void
    {
        $aviso = Aviso::factory()->create();

        $this->deleteJson("/api/v1/puestos/{$aviso->puesto_id}/avisos/{$aviso->id}")
            ->assertNoContent();
        $this->assertDatabaseMissing('avisos', ['id' => $aviso->id]);
    }
}
