<?php

namespace App\Http\Resources\V1;

use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Aviso */
final class AvisoResource extends JsonResource
{
    /**
     * Campos públicos del aviso.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'puesto_id' => $this->puesto_id,
            'titulo' => $this->titulo,
            'dias_vigencia' => $this->dias_vigencia,
            'categoria' => $this->categoria,
            'activo' => $this->activo,
        ];
    }
}
