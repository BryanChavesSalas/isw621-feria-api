<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ActualizarApartadoRequest; 
use App\Http\Requests\V1\GuardarApartadoRequest;
use App\Http\Resources\V1\ApartadoResource;
use App\Models\Apartado;
use App\Models\Puesto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class ApartadoController
{
    /** Lista los apartados activos, ordenados por nombre (A a Z), de 15 en 15. */
    public function index(Puesto $puesto): AnonymousResourceCollection
    {
        return ApartadoResource::collection(
            $puesto->apartados()->where('confirmado', true)->orderBy('cliente')->paginate(15),
        );
    }

    /** Registra un apartado en el puesto y responde 201 con su dirección en Location. */
    public function store(GuardarApartadoRequest $request, Puesto $puesto): JsonResponse
    {
        // Fuerza el estado confirmado a true por defecto al crear si lo requiere el flujo
        $datos = array_merge($request->validated(), ['confirmado' => true]);

        $apartado = $puesto->apartados()->create($datos);

        // Construcción manual de la URL para blindar el método contra colapsos de ruta en terminal
        $locationUrl = url("/api/v1/puestos/{$puesto->id}/apartados/{$apartado->id}");

        return (new ApartadoResource($apartado->refresh()))
            ->response()
            ->setStatusCode(201)
            ->header('Location', $locationUrl);
    }

    /** Detalle de un apartado del puesto. */
    public function show(Puesto $puesto, Apartado $apartado): ApartadoResource
    {
        if ($apartado->puesto_id !== $puesto->id) {
            abort(404);
        }

        return new ApartadoResource($apartado);
    }

    /** Cambia solo los campos que llegan en la solicitud. */
    public function update(ActualizarApartadoRequest $request, Puesto $puesto, Apartado $apartado): ApartadoResource
    {
        if ($apartado->puesto_id !== $puesto->id) {
            abort(404);
        }

        $apartado->update($request->validated());

        return new ApartadoResource($apartado);
    }

    /** Elimina el apartado y responde 204 sin cuerpo. */
    public function destroy(Puesto $puesto, Apartado $apartado): Response
    {
        if ($apartado->puesto_id !== $puesto->id) {
            abort(404);
        }

        $apartado->delete();

        return response()->noContent();
    }
}
