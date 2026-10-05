<?php

namespace Tests\Feature\Api\V1;

use App\Models\Cosecha;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CosechasTest extends TestCase
{
    use RefreshDatabase;

    /** El listado trae solo las cosechas confirmadas, de más a menos kilos, y nada de otros puestos. */
    #[Test]
    public function lista_solo_confirmadas_del_puesto_en_orden(): void
    {
        $puesto = Puesto::factory()->create();
        Cosecha::factory()->for($puesto)->create(['cultivo' => 'Aguacate', 'kilos_estimados' => 1]);
        Cosecha::factory()->for($puesto)->create(['cultivo' => 'Banano', 'kilos_estimados' => 5000]);
        Cosecha::factory()->for($puesto)->sinConfirmar()->create(['cultivo' => 'Chile dulce']);
        Cosecha::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/cosechas")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.cultivo', 'Banano')
            ->assertJsonPath('data.1.cultivo', 'Aguacate');
    }

    /** Crear responde 201, devuelve el recurso y dice dónde quedó en Location. */
    #[Test]
    public function crea_con_201_y_la_direccion_en_location(): void
    {
        $puesto = Puesto::factory()->create();

        $respuesta = $this->postJson("/api/v1/puestos/{$puesto->id}/cosechas", [
            'cultivo' => 'Aguacate',
            'kilos_estimados' => 5000,
            'temporada' => 'seca',
        ]);

        $id = $respuesta->assertCreated()
            ->assertJsonPath('data.cultivo', 'Aguacate')
            ->assertJsonPath('data.confirmada', true)
            ->json('data.id');
        $respuesta->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/cosechas/{$id}"));
        $this->assertDatabaseHas('cosechas', ['id' => $id, 'puesto_id' => $puesto->id]);
    }

    /** Los datos inválidos responden 422 en formato RFC 9457, con el error de cada campo. */
    #[Test]
    public function rechaza_datos_invalidos_con_422(): void
    {
        $puesto = Puesto::factory()->create();

        $this->postJson("/api/v1/puestos/{$puesto->id}/cosechas", [
            'cultivo' => str_repeat('x', 61),
            'kilos_estimados' => 5001,
            'temporada' => 'otro',
        ])
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['cultivo', 'kilos_estimados', 'temporada']);
    }

    /** Pedir una cosecha con el identificador de otro puesto responde 404. */
    #[Test]
    public function responde_404_si_es_de_otro_puesto(): void
    {
        $puesto = Puesto::factory()->create();
        $ajena = Cosecha::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/cosechas/{$ajena->id}")
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }

    /** PATCH cambia solo lo que llega; cambiar de puesto está prohibido. */
    #[Test]
    public function patch_cambia_solo_lo_enviado_y_prohibe_cambiar_el_puesto(): void
    {
        $cosecha = Cosecha::factory()->create(['cultivo' => 'Aguacate', 'kilos_estimados' => 1]);
        $ruta = "/api/v1/puestos/{$cosecha->puesto_id}/cosechas/{$cosecha->id}";

        $this->patchJson($ruta, ['kilos_estimados' => 5000])
            ->assertOk()
            ->assertJsonPath('data.kilos_estimados', 5000)
            ->assertJsonPath('data.cultivo', 'Aguacate');

        $this->patchJson($ruta, ['puesto_id' => Puesto::factory()->create()->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['puesto_id']);
    }

    /** Eliminar responde 204 sin cuerpo y borra la fila. */
    #[Test]
    public function elimina_con_204(): void
    {
        $cosecha = Cosecha::factory()->create();

        $this->deleteJson("/api/v1/puestos/{$cosecha->puesto_id}/cosechas/{$cosecha->id}")
            ->assertNoContent();
        $this->assertDatabaseMissing('cosechas', ['id' => $cosecha->id]);
    }
}
