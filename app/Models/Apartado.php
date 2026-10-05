<?php

namespace App\Models;

use App\Enums\FranjaDeEntrega;
use Database\Factories\ApartadoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('apartados')]
#[Fillable(['cliente', 'cantidad', 'entrega', 'confirmado'])]
class Apartado extends Model
{
    /** @use HasFactory<ApartadoFactory> */
    use HasFactory {
        HasFactory::newFactory as traitNewFactory;
    }

    /**
     * Define la fábrica correspondiente para el modelo.
     *
     * @return ApartadoFactory
     */
    protected static function newFactory(): Factory
    {
        return ApartadoFactory::new();
    }

    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'entrega' => FranjaDeEntrega::class,
            'confirmado' => 'boolean',
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
