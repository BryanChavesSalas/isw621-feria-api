<?php

namespace App\Http\Resources\V1;

use App\Models\Certificacion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Certificacion */
final class CertificacionResource extends JsonResource
{
    /**
     * Campos públicos de la certificación.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'puesto_id' => $this->puesto_id,
            'nombre' => $this->nombre,
            'vigencia_meses' => $this->vigencia_meses,
            'tipo' => $this->tipo,
            'verificada' => $this->verificada,
        ];
    }
}
