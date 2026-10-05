<?php

namespace App\Models;

use App\Enums\Unidad;
use Database\Factories\ProductoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('productos')]
#[Fillable(['nombre', 'precio_colones', 'unidad', 'disponible'])]
class Producto extends Model
{
    /** @use HasFactory<ProductoFactory> */
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
            'unidad' => Unidad::class,
            'disponible' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece el producto.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
