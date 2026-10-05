<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ActualizarProductoRequest;
use App\Http\Requests\V1\GuardarProductoRequest;
use App\Http\Resources\V1\ProductoResource;
use App\Models\Producto;
use App\Models\Puesto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class ProductoController
{
    /** Lista los productos disponibles, ordenados por nombre (A a Z), de 15 en 15. */
    public function index(Puesto $puesto): AnonymousResourceCollection
    {
        return ProductoResource::collection(
            $puesto->productos()->where('disponible', true)->orderBy('nombre')->paginate(15),
        );
    }

    /** Registra un producto en el puesto y responde 201 con su dirección en Location. */
    public function store(GuardarProductoRequest $request, Puesto $puesto): JsonResponse
    {
        $producto = $puesto->productos()->create($request->validated());

        return (new ProductoResource($producto->refresh()))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('v1.puestos.productos.show', [$puesto, $producto]));
    }

    /** Detalle de un producto del puesto. */
    public function show(Puesto $puesto, Producto $producto): ProductoResource
    {
        return new ProductoResource($producto);
    }

    /** Cambia solo los campos que llegan en la solicitud. */
    public function update(ActualizarProductoRequest $request, Puesto $puesto, Producto $producto): ProductoResource
    {
        $producto->update($request->validated());

        return new ProductoResource($producto);
    }

    /** Elimina el producto y responde 204 sin cuerpo. */
    public function destroy(Puesto $puesto, Producto $producto): Response
    {
        $producto->delete();

        return response()->noContent();
    }
}
