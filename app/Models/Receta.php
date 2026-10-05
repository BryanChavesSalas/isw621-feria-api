<?php

namespace App\Models;

use App\Enums\Dificultad;
use Database\Factories\RecetaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('recetas')]
#[Fillable(['titulo', 'minutos', 'dificultad', 'publicada'])]
class Receta extends Model
{
    /** @use HasFactory<RecetaFactory> */
    use HasFactory;

    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'minutos' => 'integer',
            'dificultad' => Dificultad::class,
            'publicada' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece la receta.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
