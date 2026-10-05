<?php

namespace App\Http\Resources\V1;

use App\Models\Canasta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Canasta */
final class CanastaResource extends JsonResource
{
    /**
     * Campos públicos de la canasta.
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
            'tamano' => $this->tamano,
            'disponible' => $this->disponible,
        ];
    }
}
