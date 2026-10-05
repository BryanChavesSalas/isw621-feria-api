<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ActualizarAvisoRequest;
use App\Http\Requests\V1\GuardarAvisoRequest;
use App\Http\Resources\V1\AvisoResource;
use App\Models\Aviso;
use App\Models\Puesto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class AvisoController
{
    /** Lista los avisos activos, ordenados por titulo (A a Z), de 15 en 15. */
    public function index(Puesto $puesto): AnonymousResourceCollection
    {
        return AvisoResource::collection(
            $puesto->avisos()->where('activo', true)->orderBy('titulo')->paginate(15),
        );
    }

    /** Registra un aviso en el puesto y responde 201 con su dirección en Location. */
    public function store(GuardarAvisoRequest $request, Puesto $puesto): JsonResponse
    {
        $aviso = $puesto->avisos()->create($request->validated());

        return (new AvisoResource($aviso->refresh()))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('v1.puestos.avisos.show', [$puesto, $aviso]));
    }

    /** Detalle de un aviso del puesto. */
    public function show(Puesto $puesto, Aviso $aviso): AvisoResource
    {
        return new AvisoResource($aviso);
    }

    /** Cambia solo los campos que llegan en la solicitud. */
    public function update(ActualizarAvisoRequest $request, Puesto $puesto, Aviso $aviso): AvisoResource
    {
        $aviso->update($request->validated());

        return new AvisoResource($aviso);
    }

    /** Elimina el aviso y responde 204 sin cuerpo. */
    public function destroy(Puesto $puesto, Aviso $aviso): Response
    {
        $aviso->delete();

        return response()->noContent();
    }
}
