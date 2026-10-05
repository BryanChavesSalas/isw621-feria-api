<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ActualizarRecetaRequest;
use App\Http\Requests\V1\GuardarRecetaRequest;
use App\Http\Resources\V1\RecetaResource;
use App\Models\Puesto;
use App\Models\Receta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class RecetaController extends Controller
{
    /**
     * Lista las recetas publicadas del puesto, de la más rápida a la más lenta.
     */
    public function index(Puesto $puesto): AnonymousResourceCollection
    {
        return RecetaResource::collection(
            $puesto->recetas()->where('publicada', true)->orderBy('minutos')->paginate(15),
        );
    }

    /**
     * Registra una receta en el puesto.
     */
    public function store(GuardarRecetaRequest $request, Puesto $puesto): JsonResponse
    {
        $receta = $puesto->recetas()->create($request->validated());
        $receta->refresh();

        return (new RecetaResource($receta))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('v1.puestos.recetas.show', [$puesto, $receta]));
    }

    /**
     * Muestra una receta del puesto.
     */
    public function show(Puesto $puesto, Receta $receta): RecetaResource
    {
        return new RecetaResource($receta);
    }

    /**
     * Actualiza solo los campos enviados.
     */
    public function update(ActualizarRecetaRequest $request, Puesto $puesto, Receta $receta): RecetaResource
    {
        $receta->update($request->validated());

        return new RecetaResource($receta);
    }

    /**
     * Elimina la receta.
     */
    public function destroy(Puesto $puesto, Receta $receta): Response
    {
        $receta->delete();

        return response()->noContent();
    }
}