<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\PuestoResource;
use App\Models\Puesto;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PuestoController
{
    /** Puestos de la feria, ordenados por nombre y de 15 en 15. */
    public function index(): AnonymousResourceCollection
    {
        return PuestoResource::collection(Puesto::query()->orderBy('nombre')->paginate(15));
    }

    /** Detalle de un puesto. */
    public function show(Puesto $puesto): PuestoResource
    {
        return new PuestoResource($puesto);
    }
}
