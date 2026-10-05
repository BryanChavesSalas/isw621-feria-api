<?php

namespace App\Http\Resources\V1;

use App\Models\Cosecha;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Cosecha */
final class CosechaResource extends JsonResource
{
    /**
     * Campos públicos de la cosecha.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'puesto_id' => $this->puesto_id,
            'cultivo' => $this->cultivo,
            'kilos_estimados' => $this->kilos_estimados,
            'temporada' => $this->temporada,
            'confirmada' => $this->confirmada,
        ];
    }
}
