<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ActualizarCosechaRequest;
use App\Http\Requests\V1\GuardarCosechaRequest;
use App\Http\Resources\V1\CosechaResource;
use App\Models\Cosecha;
use App\Models\Puesto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class CosechaController
{
    /** Lista las cosechas confirmadas, de más a menos kilos estimados, de 15 en 15. */
    public function index(Puesto $puesto): AnonymousResourceCollection
    {
        return CosechaResource::collection(
            $puesto->cosechas()->where('confirmada', true)->orderByDesc('kilos_estimados')->paginate(15),
        );
    }

    /** Registra una cosecha en el puesto y responde 201 con su dirección en Location. */
    public function store(GuardarCosechaRequest $request, Puesto $puesto): JsonResponse
    {
        $cosecha = $puesto->cosechas()->create($request->validated());

        return (new CosechaResource($cosecha->refresh()))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('v1.puestos.cosechas.show', [$puesto, $cosecha]));
    }

    /** Detalle de una cosecha del puesto. */
    public function show(Puesto $puesto, Cosecha $cosecha): CosechaResource
    {
        return new CosechaResource($cosecha);
    }

    /** Cambia solo los campos que llegan en la solicitud. */
    public function update(ActualizarCosechaRequest $request, Puesto $puesto, Cosecha $cosecha): CosechaResource
    {
        $cosecha->update($request->validated());

        return new CosechaResource($cosecha);
    }

    /** Elimina la cosecha y responde 204 sin cuerpo. */
    public function destroy(Puesto $puesto, Cosecha $cosecha): Response
    {
        $cosecha->delete();

        return response()->noContent();
    }
}
