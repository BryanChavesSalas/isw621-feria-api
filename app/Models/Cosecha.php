<?php

namespace App\Models;

use App\Enums\Temporada;
use Database\Factories\CosechaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('cosechas')]
#[Fillable(['cultivo', 'kilos_estimados', 'temporada', 'confirmada'])]
class Cosecha extends Model
{
    /** @use HasFactory<CosechaFactory> */
    use HasFactory;

    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kilos_estimados' => 'integer',
            'temporada' => Temporada::class,
            'confirmada' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece la cosecha.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
