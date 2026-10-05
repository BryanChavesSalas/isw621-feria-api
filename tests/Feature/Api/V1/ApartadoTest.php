<?php

namespace Tests\Feature\Api\V1;

use App\Enums\FranjaDeEntrega;
use App\Models\Apartado;
use App\Models\Puesto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApartadoTest extends TestCase
{
    use RefreshDatabase; // Vacía la base de datos de pruebas en cada intento

    /**
     * 1. POST exitoso -> Devuelve 201 y encabezado Location
     */
    public function test_puede_crear_un_apartado_valido(): void
    {
        $puesto = Puesto::factory()->create();

        $datos = [
            'cliente' => 'Andrea',
            'cantidad' => 50,
            'entrega' => 'sabado_manana', // Asegúrate de que coincida con un valor de tu Enum
        ];

        $response = $this->postJson("/api/v1/puestos/{$puesto->id}/apartados", $datos);

        // Verifica código 201 Created
        $response->assertStatus(201);
        
        // Verifica que se devuelva la estructura del recurso
        $response->assertJsonStructure([
            'data' => ['id', 'cliente', 'cantidad', 'entrega']
        ]);

        // Verifica que exista el encabezado Location exigido
        $idCreado = $response->json('data.id');
        $response->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/apartados/{$idCreado}"));
    }

    /**
     * 2. POST fallido -> Devuelve 422 con los tres errores de validación
     */
    public function test_valida_campos_obligatorios_y_restricciones_al_crear(): void
    {
        $puesto = Puesto::factory()->create();

        $datosIncorrectos = [
            'cliente' => '',        // Vacío -> Error 1
            'cantidad' => 51,       // Mayor a 50 -> Error 2
            'entrega' => 'otro',    // No pertenece al Enum -> Error 3
        ];

        $response = $this->postJson("/api/v1/puestos/{$puesto->id}/apartados", $datosIncorrectos);

        // Verifica código 422 Unprocessable Entity
        $response->assertStatus(422);

        // Verifica que los tres campos reporten fallas de validación
        $response->assertJsonValidationErrors(['cliente', 'cantidad', 'entrega']);
    }

    /**
     * 3. GET lista -> Devuelve 200, ordenados de A a Z y solo confirmados
     */
    public function test_lista_apartados_confirmados_ordenados_por_cliente(): void
    {
        $puesto = Puesto::factory()->create();

        // Creamos escenarios para forzar el cumplimiento del documento
        Apartado::factory()->create(['puesto_id' => $puesto->id, 'cliente' => 'Carlos', 'confirmado' => true]);
        Apartado::factory()->create(['puesto_id' => $puesto->id, 'cliente' => 'Ana', 'confirmado' => true]);
        Apartado::factory()->create(['puesto_id' => $puesto->id, 'cliente' => 'Bernardo', 'confirmado' => false]); // No debe salir

        $response = $this->getJson("/api/v1/puestos/{$puesto->id}/apartados");

        $response->assertStatus(200);
        
        // Comprobamos que solo trajo los 2 confirmados
        $response->assertJsonCount(2, 'data');

        // Comprobamos el orden alfabético estricto (A a Z)
        $this->assertEquals('Ana', $response->json('data.0.cliente'));
        $this->assertEquals('Carlos', $response->json('data.1.cliente'));
    }

    /**
     * 4. GET Cruzado -> Devuelve 404 si el apartado pertenece a otro puesto
     */
    public function test_devuelve_404_si_el_apartado_pertenece_a_otro_puesto(): void
    {
        $puestoDondeSeCreo = Puesto::factory()->create();
        $puestoIntruso = Puesto::factory()->create();

        $apartado = Apartado::factory()->create(['puesto_id' => $puestoDondeSeCreo->id]);

        // Intentamos consultar el apartado usando la ruta del "puestoIntruso"
        $response = $this->getJson("/api/v1/puestos/{$puestoIntruso->id}/apartados/{$apartado->id}");

        $response->assertStatus(404);
    }

    /**
     * 5. PATCH -> Devuelve 200 y modifica solo la cantidad
     */
    public function test_puede_actualizar_solo_la_cantidad_del_apartado(): void
    {
        $puesto = Puesto::factory()->create();
        $apartado = Apartado::factory()->create(['puesto_id' => $puesto->id, 'cantidad' => 10]);

        $response = $this->patchJson("/api/v1/puestos/{$puesto->id}/apartados/{$apartado->id}", [
            'cantidad' => 1
        ]);

        $response->assertStatus(200);
        
        // Verifica el cambio en la base de datos
        $this->assertDatabaseHas('apartados', [
            'id' => $apartado->id,
            'cantidad' => 1
        ]);
    }

    /**
     * 6. DELETE -> Devuelve 204 sin cuerpo
     */
    public function test_puede_eliminar_un_apartado(): void
    {
        $puesto = Puesto::factory()->create();
        $apartado = Apartado::factory()->create(['puesto_id' => $puesto->id]);

        $response = $this->deleteJson("/api/v1/puestos/{$puesto->id}/apartados/{$apartado->id}");

        // Verifica código 204 No Content
        $response->assertStatus(204);
        
        // Verifica que el cuerpo de la respuesta esté vacío
        $this->assertEmpty($response->getContent());

        // Verifica que ya no exista en la base de datos
        $this->assertDatabaseMissing('apartados', ['id' => $apartado->id]);
    }
}