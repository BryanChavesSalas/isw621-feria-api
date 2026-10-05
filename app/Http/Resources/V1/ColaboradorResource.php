<?php

namespace App\Http\Resources\V1;

use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Colaborador */
final class ColaboradorResource extends JsonResource
{
    /**
     * Campos públicos del colaborador.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'puesto_id' => $this->puesto_id,
            'nombre' => $this->nombre,
            'horas_semanales' => $this->horas_semanales,
            'rol' => $this->rol,
            'activo' => $this->activo,
        ];
    }
}
