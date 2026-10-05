<?php

namespace App\Models;

use App\Enums\Jornada;
use Database\Factories\DegustacionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


#[Table('inspecciones')]
#[Fillable(['acta', 'puntaje', 'resultado', 'publicada'])]
class Inspeccion extends Model
{
    /** @use HasFactory<InspeccionFactory> */
    use HasFactory;
 
    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'puntaje' => 'integer',
            'resultado' => ResultadoDeInspeccion::class,
            'publicada' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece la degustación.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
