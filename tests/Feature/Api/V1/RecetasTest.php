<?php

namespace Tests\Feature\Api\V1;

use App\Models\Puesto;
use App\Models\Receta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RecetasTest extends TestCase
{
    use RefreshDatabase;

    /** El listado trae solo las recetas publicadas, de la más rápida a la más lenta, y nada de otros puestos. */
    #[Test]
    public function lista_solo_publicadas_del_puesto_en_orden(): void
    {
        $puesto = Puesto::factory()->create();
        Receta::factory()->for($puesto)->create(['titulo' => 'Arroz con palmito', 'minutos' => 240]);
        Receta::factory()->for($puesto)->create(['titulo' => 'Bizcocho', 'minutos' => 5]);
        Receta::factory()->for($puesto)->sinPublicar()->create(['titulo' => 'Chorreadas']);
        Receta::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/recetas")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.titulo', 'Bizcocho')
            ->assertJsonPath('data.1.titulo', 'Arroz con palmito');
    }

    /** Crear responde 201, devuelve el recurso y dice dónde quedó en Location. */
    #[Test]
    public function crea_con_201_y_la_direccion_en_location(): void
    {
        $puesto = Puesto::factory()->create();

        $respuesta = $this->postJson("/api/v1/puestos/{$puesto->id}/recetas", [
            'titulo' => 'Arroz con palmito',
            'minutos' => 240,
            'dificultad' => 'facil',
        ]);

        $id = $respuesta->assertCreated()
            ->assertJsonPath('data.titulo', 'Arroz con palmito')
            ->assertJsonPath('data.publicada', true)
            ->json('data.id');
        $respuesta->assertHeader('Location', url("/api/v1/puestos/{$puesto->id}/recetas/{$id}"));
        $this->assertDatabaseHas('recetas', ['id' => $id, 'puesto_id' => $puesto->id]);
    }

    /** Los datos inválidos responden 422 en formato RFC 9457, con el error de cada campo. */
    #[Test]
    public function rechaza_datos_invalidos_con_422(): void
    {
        $puesto = Puesto::factory()->create();

        $this->postJson("/api/v1/puestos/{$puesto->id}/recetas", [
            'titulo' => str_repeat('x', 81),
            'minutos' => 241,
            'dificultad' => 'otro',
        ])
            ->assertUnprocessable()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonValidationErrors(['titulo', 'minutos', 'dificultad']);
    }

    /** Pedir una receta con el identificador de otro puesto responde 404. */
    #[Test]
    public function responde_404_si_es_de_otro_puesto(): void
    {
        $puesto = Puesto::factory()->create();
        $ajena = Receta::factory()->create();

        $this->getJson("/api/v1/puestos/{$puesto->id}/recetas/{$ajena->id}")
            ->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json');
    }

    /** PATCH cambia solo lo que llega; cambiar de puesto está prohibido. */
    #[Test]
    public function patch_cambia_solo_lo_enviado_y_prohibe_cambiar_el_puesto(): void
    {
        $receta = Receta::factory()->create(['titulo' => 'Arroz con palmito', 'minutos' => 5]);
        $ruta = "/api/v1/puestos/{$receta->puesto_id}/recetas/{$receta->id}";

        $this->patchJson($ruta, ['minutos' => 240])
            ->assertOk()
            ->assertJsonPath('data.minutos', 240)
            ->assertJsonPath('data.titulo', 'Arroz con palmito');

        $this->patchJson($ruta, ['puesto_id' => Puesto::factory()->create()->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['puesto_id']);
    }

    /** Eliminar responde 204 sin cuerpo y borra la fila. */
    #[Test]
    public function elimina_con_204(): void
    {
        $receta = Receta::factory()->create();

        $this->deleteJson("/api/v1/puestos/{$receta->puesto_id}/recetas/{$receta->id}")
            ->assertNoContent();
        $this->assertDatabaseMissing('recetas', ['id' => $receta->id]);
    }
}
