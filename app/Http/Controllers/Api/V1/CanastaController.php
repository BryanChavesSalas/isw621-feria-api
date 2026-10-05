<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ActualizarCanastaRequest;
use App\Http\Requests\V1\GuardarCanastaRequest;
use App\Http\Resources\V1\CanastaResource;
use App\Models\Canasta;
use App\Models\Puesto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class CanastaController
{
    /** Lista las canastas disponibles, de la más barata a la más cara, de 15 en 15. */
    public function index(Puesto $puesto): AnonymousResourceCollection
    {
        return CanastaResource::collection(
            $puesto->canastas()->where('disponible', true)->orderBy('precio_colones')->paginate(15),
        );
    }

    /** Registra una canasta en el puesto y responde 201 con su dirección en Location. */
    public function store(GuardarCanastaRequest $request, Puesto $puesto): JsonResponse
    {
        $canasta = $puesto->canastas()->create($request->validated());

        return (new CanastaResource($canasta->refresh()))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('v1.puestos.canastas.show', [$puesto, $canasta]));
    }

    /** Detalle de una canasta del puesto. */
    public function show(Puesto $puesto, Canasta $canasta): CanastaResource
    {
        return new CanastaResource($canasta);
    }

    /** Cambia solo los campos que llegan en la solicitud. */
    public function update(ActualizarCanastaRequest $request, Puesto $puesto, Canasta $canasta): CanastaResource
    {
        $canasta->update($request->validated());

        return new CanastaResource($canasta);
    }

    /** Elimina la canasta y responde 204 sin cuerpo. */
    public function destroy(Puesto $puesto, Canasta $canasta): Response
    {
        $canasta->delete();

        return response()->noContent();
    }
}
