<?php

namespace App\Models;

use App\Enums\Canal;
use Database\Factories\ResenaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('resenas')]
#[Fillable(['autor', 'calificacion', 'canal', 'visible'])]
class Resena extends Model
{
    /** @use HasFactory<ResenaFactory> */
    use HasFactory;

    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'calificacion' => 'integer',
            'canal' => Canal::class,
            'visible' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece la reseña.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
