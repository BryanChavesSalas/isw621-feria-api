<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Degustacion */
final class ApartadoResource extends JsonResource
{
    /**
     * Campos públicos de la degustación.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'puesto_id' => $this->puesto_id,
            'cliente' => $this->cliente,
            'cantidad' => $this->cantidad,
            'entrega' => $this->entrega,
            'confirmado' => $this->confirmado,
        ];
    }
}
