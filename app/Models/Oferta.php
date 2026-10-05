<?php

namespace App\Models;

use App\Enums\TipoDeOferta;
use Database\Factories\OfertaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('ofertas')]
#[Fillable(['titulo', 'descuento_porcentaje', 'tipo', 'vigente'])]
class Oferta extends Model
{
    /** @use HasFactory<OfertaFactory> */
    use HasFactory;

    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'descuento_porcentaje' => 'integer',
            'tipo' => TipoDeOferta::class,
            'vigente' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece la oferta.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}