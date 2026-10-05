<?php

namespace App\Models;

use App\Database\Factories\CanastaFactory;
use App\Enums\TamanoDeCanasta;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('canastas')]
#[Fillable(['nombre', 'precio_colones', 'tamano', 'disponible'])]
class Canasta extends Model
{
    /** @use HasFactory<CanastaFactory> */
    use HasFactory;

    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'precio_colones' => 'integer',
            'tamano' => TamanoDeCanasta::class,
            'disponible' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece la canasta.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
