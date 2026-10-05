<?php

namespace App\Http\Resources\V1;

use App\Models\Puesto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Puesto */
final class PuestoResource extends JsonResource
{
    /**
     * Campos públicos del puesto.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
        ];
    }
}
