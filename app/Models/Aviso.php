<?php

namespace App\Models;

use App\Enums\CategoriaDeAviso;
use Database\Factories\AvisoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('avisos')]
#[Fillable(['titulo', 'dias_vigencia', 'categoria', 'activo'])]
class Aviso extends Model
{
    /** @use HasFactory<AvisoFactory> */
    use HasFactory;

    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dias_vigencia' => 'integer',
            'categoria' => CategoriaDeAviso::class,
            'activo' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece el aviso.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
