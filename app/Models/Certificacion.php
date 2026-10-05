<?php

namespace App\Models;

use App\Enums\TipoDeCertificacion;
use Database\Factories\CertificacionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('certificaciones')]
#[Fillable(['nombre', 'vigencia_meses', 'tipo', 'verificada'])]
class Certificacion extends Model
{
    /** @use HasFactory<CertificacionFactory> */
    use HasFactory;

    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'vigencia_meses' => 'integer',
            'tipo' => TipoDeCertificacion::class,
            'verificada' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece la certificación.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
