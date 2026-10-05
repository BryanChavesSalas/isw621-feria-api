<?php

namespace Tests\Feature\Api\V1;

use App\Models\Producto;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProductosTest extends TestCase
{
    use RefreshDatabase;

    /** El listado trae solo los productos disponibles, ordenados por nombre (A a Z), y nada de otros puestos. */
    #[Test]
    public function lista_solo_disponibles_del_puesto_en_orden(): void
    {
        $puesto = Puesto::factory()->create();
        Producto::factory()->for($puesto)->create(['nombre' => 'Chayote', 'precio_colones' => 50]);
        Producto::factory()->for($puesto)->create(['nombre' => 'Papa', 'precio_colones' => 200000]);
        Producto::factory()->for($puesto)->noDisponible()->create(['nombre' => 'Culantro']);
        Producto::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/productos")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.nombre', 'Chayote')
            ->assertJsonPath('data.1.nombre', 'Papa');
    }

    /** Crear responde 201, devuelve el recurso y dice dónde quedó en Location. */
    #[Test]
    public function crea_con_201_y_la_direccion_en_location(): void
    {
        $puesto = Puesto::factory()->create();

        $respuesta = $this->postJson("/api/v1/puestos/{$puesto->id}/productos", [
            'nombre' => 'Papa',
            'precio_colones' => 200000,
            'unidad' => 'kg',
        ]);

        $id = $respuesta->assertCreated()
            ->assertJsonPath('data.nombre', 'Papa')
            ->assertJsonPath('data.unidad', 'kg')
            ->assertJsonPath('data.disponible', true)
            ->json('data.id');
        $respuesta->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/productos/{$id}"));
        $this->assertDatabaseHas('productos', ['id' => $id, 'puesto_id' => $puesto->id]);
    }

    /** Los datos inválidos responden 422 en formato RFC 9457, con el error de cada campo. */
    #[Test]
    public function rechaza_datos_invalidos_con_422(): void
    {
        $puesto = Puesto::factory()->create();

        $this->postJson("/api/v1/puestos/{$puesto->id}/productos", [
            'nombre' => '',
            'precio_colones' => 200001,
            'unidad' => 'otro',
        ])
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['nombre', 'precio_colones', 'unidad']);
    }

    /** Pedir un producto con el identificador de otro puesto responde 404. */
    #[Test]
    public function responde_404_si_es_de_otro_puesto(): void
    {
        $puesto = Puesto::factory()->create();
        $ajeno = Producto::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/productos/{$ajeno->id}")
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }

    /** PATCH cambia solo lo que llega; cambiar de puesto está prohibido. */
    #[Test]
    public function patch_cambia_solo_lo_enviado_y_prohibe_cambiar_el_puesto(): void
    {
        $producto = Producto::factory()->create(['nombre' => 'Papa', 'precio_colones' => 200000]);
        $ruta = "/api/v1/puestos/{$producto->puesto_id}/productos/{$producto->id}";

        $this->patchJson($ruta, ['precio_colones' => 50])
            ->assertOk()
            ->assertJsonPath('data.precio_colones', 50)
            ->assertJsonPath('data.nombre', 'Papa');

        $this->patchJson($ruta, ['puesto_id' => Puesto::factory()->create()->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['puesto_id']);
    }

    /** Eliminar responde 204 sin cuerpo y borra la fila. */
    #[Test]
    public function elimina_con_204(): void
    {
        $producto = Producto::factory()->create();

        $this->deleteJson("/api/v1/puestos/{$producto->puesto_id}/productos/{$producto->id}")
            ->assertNoContent();
        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }
}
