<?php

namespace App\Models;

use App\Enums\TamanoDeCanasta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Canasta extends Model
{
    use HasFactory;

    protected $fillable = [
        'puesto_id',
        'nombre',
        'tamano',
        'precio_colones',
        'disponible',
    ];

    protected $casts = [
        'tamano' => TamanoDeCanasta::class,
        'disponible' => 'boolean',
        'precio_colones' => 'integer',
    ];

    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
