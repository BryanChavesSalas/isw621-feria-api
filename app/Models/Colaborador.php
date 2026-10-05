<?php

namespace App\Models;

use App\Enums\RolDeColaborador;
use Database\Factories\ColaboradorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('colaboradores')]
#[Fillable(['nombre', 'horas_semanales', 'rol', 'activo'])]
class Colaborador extends Model
{
    /** @use HasFactory<ColaboradorFactory> */
    use HasFactory;

    /**
     * Tipos de los atributos: el enum y el booleano llegan ya convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'horas_semanales' => 'integer',
            'rol' => RolDeColaborador::class,
            'activo' => 'boolean',
        ];
    }

    /**
     * Puesto al que pertenece el colaborador.
     *
     * @return BelongsTo<Puesto, $this>
     */
    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
