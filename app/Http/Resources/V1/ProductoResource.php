<?php

namespace App\Http\Resources\V1;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Producto */
final class ProductoResource extends JsonResource
{
    /**
     * Campos públicos del producto.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'puesto_id' => $this->puesto_id,
            'nombre' => $this->nombre,
            'precio_colones' => $this->precio_colones,
            'unidad' => $this->unidad,
            'disponible' => $this->disponible,
        ];
    }
}
