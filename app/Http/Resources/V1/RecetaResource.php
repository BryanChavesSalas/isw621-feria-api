<?php

namespace App\Http\Resources\V1;

use App\Models\Degustacion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Degustacion */
final class DegustacionResource extends JsonResource
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
        'titulo' => $this->titulo,
        'minutos' => $this->minutos,
        'dificultad' => $this->dificultad,
        'publicada' => $this->publicada,
        ];
    }
}
