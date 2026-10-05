<?php

namespace Tests\Feature\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProblemasTest extends TestCase
{
    private const string TIPOS = 'https://api.feria.test/problemas/';

    /** Una ruta inexistente responde 404 con el instance igual al X-Request-Id. */
    #[Test]
    public function una_ruta_inexistente_responde_un_problema_con_su_identificador(): void
    {
        $respuesta = $this->getJson('/api/v1/ruta-que-no-existe');

        $respuesta->assertNotFound()
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertExactJson([
                'type' => self::TIPOS.'no-encontrado',
                'title' => 'Recurso no encontrado',
                'status' => 404,
                'detail' => 'El recurso solicitado no existe.',
                'instance' => 'urn:uuid:'.$respuesta->headers->get('X-Request-Id'),
            ]);
    }

    /** Un método que la ruta no acepta responde 405. */
    #[Test]
    public function un_metodo_no_permitido_responde_405(): void
    {
        Route::get('/api/v1/prueba', fn () => 'ok');

        $this->deleteJson('/api/v1/prueba')
            ->assertStatus(405)
            ->assertJsonPath('type', self::TIPOS.'metodo-no-permitido');
    }

    /** Los datos inválidos responden 422 con los errores por campo. */
    #[Test]
    public function los_datos_invalidos_responden_422_con_los_errores_por_campo(): void
    {
        Route::post('/api/v1/prueba', fn (Request $request) => $request->validate(['nombre' => 'required']));

        $this->postJson('/api/v1/prueba')
            ->assertUnprocessable()
            ->assertJsonPath('type', self::TIPOS.'datos-invalidos')
            ->assertJsonPath('detail', 'Uno o más campos no cumplen las reglas.')
            ->assertJsonStructure(['errors' => ['nombre']]);
    }

    /** Los mensajes de validación llegan en español, como promete el contrato. */
    #[Test]
    public function los_mensajes_de_validacion_llegan_en_espanol(): void
    {
        Route::post('/api/v1/prueba', fn (Request $request) => $request->validate(['unidad' => 'required']));

        $this->postJson('/api/v1/prueba')
            ->assertUnprocessable()
            ->assertJsonPath('errors.unidad.0', 'El campo unidad es obligatorio.');
    }

    /** Una ruta protegida sin token responde 401 e indica el esquema Bearer. */
    #[Test]
    public function sin_token_responde_401_con_el_esquema_bearer(): void
    {
        Route::get('/api/v1/prueba', fn () => 'ok')->middleware('auth:sanctum');

        $this->getJson('/api/v1/prueba')
            ->assertUnauthorized()
            ->assertHeader('WWW-Authenticate', 'Bearer')
            ->assertJsonPath('type', self::TIPOS.'no-autenticado');
    }

    /** Superar el límite de solicitudes responde 429 con Retry-After. */
    #[Test]
    public function superar_el_limite_responde_429_con_retry_after(): void
    {
        Route::get('/api/v1/prueba', fn () => 'ok')->middleware('throttle:1,1');

        $this->getJson('/api/v1/prueba')->assertOk();
        $this->getJson('/api/v1/prueba')
            ->assertTooManyRequests()
            ->assertHeader('Retry-After')
            ->assertJsonPath('type', self::TIPOS.'demasiadas-solicitudes');
    }

    /** Cada código HTTP del catálogo responde con su tipo genérico. */
    #[Test]
    #[DataProvider('codigosDelCatalogo')]
    public function cada_codigo_http_del_catalogo_responde_su_tipo(int $estado, string $tipo): void
    {
        Route::get('/api/v1/prueba', fn () => abort($estado));

        $this->getJson('/api/v1/prueba')
            ->assertStatus($estado)
            ->assertHeader('Content-Type', 'application/problem+json')
            ->assertJsonPath('type', self::TIPOS.$tipo);
    }

    /**
     * Códigos HTTP genéricos del catálogo de problemas.
     *
     * @return array<string, array{int, string}>
     */
    public static function codigosDelCatalogo(): array
    {
        return [
            'solicitud inválida' => [400, 'solicitud-invalida'],
            'acceso prohibido' => [403, 'prohibido'],
            'conflicto' => [409, 'conflicto'],
            'servicio no disponible' => [503, 'servicio-no-disponible'],
        ];
    }

    /** Un código sin semántica propia responde about:blank con su texto estándar. */
    #[Test]
    public function un_codigo_sin_semantica_propia_responde_about_blank(): void
    {
        Route::get('/api/v1/prueba', fn () => abort(418));

        $this->getJson('/api/v1/prueba')
            ->assertStatus(418)
            ->assertJsonPath('type', 'about:blank')
            ->assertJsonPath('title', "I'm a teapot");
    }

    /** En producción un error interno no revela SQL, clases ni trazas. */
    #[Test]
    public function en_produccion_un_error_interno_no_revela_detalles(): void
    {
        config(['app.debug' => false]);
        Route::get('/api/v1/prueba', fn () => DB::select('select * from tabla_que_no_existe'));

        $respuesta = $this->getJson('/api/v1/prueba')
            ->assertInternalServerError()
            ->assertJsonPath('type', self::TIPOS.'error-interno')
            ->assertJsonMissingPath('debug')
            ->assertJsonMissingPath('trace');

        $this->assertStringNotContainsString('tabla_que_no_existe', (string) $respuesta->getContent());
        $this->assertStringNotContainsString('SQLSTATE', (string) $respuesta->getContent());
        $this->assertStringNotContainsString('QueryException', (string) $respuesta->getContent());
    }

    /** En desarrollo el error interno agrega su origen, pero nunca la traza. */
    #[Test]
    public function en_desarrollo_el_error_interno_agrega_su_origen_sin_traza(): void
    {
        config(['app.debug' => true]);
        Route::get('/api/v1/prueba', fn () => throw new \RuntimeException('Falla de prueba'));

        $this->getJson('/api/v1/prueba')
            ->assertInternalServerError()
            ->assertJsonPath('debug.excepcion', \RuntimeException::class)
            ->assertJsonPath('debug.mensaje', 'Falla de prueba')
            ->assertJsonMissingPath('trace');
    }
}
