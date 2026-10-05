<?php

namespace App\Http\Resources\V1;

use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Receta */
final class RecetaResource extends JsonResource
{
    /**
     * Campos públicos de la receta.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'puesto_id' => $this->puesto_id,
            'titulo' => $this->titulo,
            'minutos' => $this->minutos,
            'dificultad' => $this->dificultad,
            'publicada' => $this->publicada,
        ];
    }
}