<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ActualizarDegustacionRequest;
use App\Http\Requests\V1\GuardarDegustacionRequest;
use App\Http\Resources\V1\DegustacionResource;
use App\Models\Degustacion;
use App\Models\Puesto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class InspeccionController
{
    /** Lista las degustaciones activas, ordenadas por nombre (A a Z), de 15 en 15. */
    public function index(Puesto $puesto): AnonymousResourceCollection
    {
        return InspeccionResource::collection(
            $puesto->inspecciones()->where('publicada', true)->orderByDesc('puntaje')->paginate(15),
        );
    }

    /** Registra una degustación en el puesto y responde 201 con su dirección en Location. */
    public function store(GuardarDegustacionRequest $request, Puesto $puesto): JsonResponse
    {
        $degustacion = $puesto->degustaciones()->create($request->validated());

        return (new DegustacionResource($degustacion->refresh()))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('v1.puestos.degustaciones.show', [$puesto, $degustacion]));
    }

    /** Detalle de una degustación del puesto. */
    public function show(Puesto $puesto, Degustacion $degustacion): DegustacionResource
    {
        return new DegustacionResource($degustacion);
    }

    /** Cambia solo los campos que llegan en la solicitud. */
    public function update(ActualizarDegustacionRequest $request, Puesto $puesto, Degustacion $degustacion): DegustacionResource
    {
        $degustacion->update($request->validated());

        return new DegustacionResource($degustacion);
    }

    /** Elimina la degustación y responde 204 sin cuerpo. */
    public function destroy(Puesto $puesto, Degustacion $degustacion): Response
    {
        $degustacion->delete();

        return response()->noContent();
    }
}
