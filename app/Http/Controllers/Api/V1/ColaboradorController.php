<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ActualizarColaboradorRequest;
use App\Http\Requests\V1\GuardarColaboradorRequest;
use App\Http\Resources\V1\ColaboradorResource;
use App\Models\Colaborador;
use App\Models\Puesto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class ColaboradorController
{
    /** Lista los colaboradores activos, ordenados por nombre (A a Z), de 15 en 15. */
    public function index(Puesto $puesto): AnonymousResourceCollection
    {
        return ColaboradorResource::collection(
            $puesto->colaboradores()->where('activo', true)->orderBy('nombre')->paginate(15),
        );
    }

    /** Registra un colaborador en el puesto y responde 201 con su dirección en Location. */
    public function store(GuardarColaboradorRequest $request, Puesto $puesto): JsonResponse
    {
        $colaborador = $puesto->colaboradores()->create($request->validated());

        return (new ColaboradorResource($colaborador->refresh()))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('v1.puestos.colaboradores.show', [$puesto, $colaborador]));
    }

    /** Detalle de un colaborador del puesto. */
    public function show(Puesto $puesto, Colaborador $colaborador): ColaboradorResource
    {
        return new ColaboradorResource($colaborador);
    }

    /** Cambia solo los campos que llegan en la solicitud. */
    public function update(ActualizarColaboradorRequest $request, Puesto $puesto, Colaborador $colaborador): ColaboradorResource
    {
        $colaborador->update($request->validated());

        return new ColaboradorResource($colaborador);
    }

    /** Elimina el colaborador y responde 204 sin cuerpo. */
    public function destroy(Puesto $puesto, Colaborador $colaborador): Response
    {
        $colaborador->delete();

        return response()->noContent();
    }
}
