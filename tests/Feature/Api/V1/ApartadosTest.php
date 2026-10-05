<?php

namespace Tests\Feature\Api\V1;

use App\Models\Apartado;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ApartadosTest extends TestCase
{
    use RefreshDatabase;

    /** El listado trae solo los apartados confirmados, ordenados por cliente (A a Z), y nada de otros puestos. */
    #[Test]
    public function lista_solo_confirmados_del_puesto_en_orden(): void
    {
        $puesto = Puesto::factory()->create();
        Apartado::factory()->for($puesto)->create(['cliente' => 'Beto', 'cantidad' => 1]);
        Apartado::factory()->for($puesto)->create(['cliente' => 'Andrea', 'cantidad' => 50]);
        Apartado::factory()->for($puesto)->sinConfirmar()->create(['cliente' => 'Carla']);
        Apartado::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/apartados")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.cliente', 'Andrea')
            ->assertJsonPath('data.1.cliente', 'Beto');
    }

    /** Crear responde 201, devuelve el recurso y dice dónde quedó en Location. */
    #[Test]
    public function crea_con_201_y_la_direccion_en_location(): void
    {
        $puesto = Puesto::factory()->create();

        $respuesta = $this->postJson("/api/v1/puestos/{$puesto->id}/apartados", [
            'cliente' => 'Beto',
            'cantidad' => 50,
            'entrega' => 'sabado_manana',
        ]);

        $id = $respuesta->assertCreated()
            ->assertJsonPath('data.cliente', 'Beto')
            ->assertJsonPath('data.confirmado', true)
            ->json('data.id');

        $respuesta->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/apartados/{$id}"));
        $this->assertDatabaseHas('apartados', ['id' => $id, 'puesto_id' => $puesto->id]);
    }

    /** Los datos inválidos responden 422 en formato RFC 9457, con el error de cada campo. */
    #[Test]
    public function rechaza_datos_invalidos_con_422(): void
    {
        $puesto = Puesto::factory()->create();

        $this->postJson("/api/v1/puestos/{$puesto->id}/apartados", [
            'cliente' => str_repeat('x', 61),
            'cantidad' => 51,
            'entrega' => 'otro',
        ])
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['cliente', 'cantidad', 'entrega']);
    }

    /** Pedir un apartado con el identificador de otro puesto responde 404. */
    #[Test]
    public function responde_404_si_es_de_otro_puesto(): void
    {
        $puesto = Puesto::factory()->create();
        $ajeno = Apartado::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/apartados/{$ajeno->id}")
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }

    /** PATCH cambia solo lo que llega; cambiar de puesto está prohibido. */
    #[Test]
    public function patch_cambia_solo_lo_enviado_y_prohibe_cambiar_el_puesto(): void
    {
        $apartado = Apartado::factory()->create(['cliente' => 'Andrea', 'cantidad' => 1]);
        $ruta = "/api/v1/puestos/{$apartado->puesto_id}/apartados/{$apartado->id}";

        $this->patchJson($ruta, ['cantidad' => 50])
            ->assertOk()
            ->assertJsonPath('data.cantidad', 50)
            ->assertJsonPath('data.cliente', 'Andrea');

        $this->patchJson($ruta, ['puesto_id' => Puesto::factory()->create()->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['puesto_id']);
    }

    /** Eliminar responde 204 sin cuerpo y borra la fila. */
    #[Test]
    public function elimina_con_204(): void
    {
        $apartado = Apartado::factory()->create();

        $this->deleteJson("/api/v1/puestos/{$apartado->puesto_id}/apartados/{$apartado->id}")
            ->assertNoContent();
        $this->assertDatabaseMissing('apartados', ['id' => $apartado->id]);
    }
}
