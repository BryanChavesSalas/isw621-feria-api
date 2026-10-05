<?php

namespace App\Http\Requests\V1;

use App\Enums\RolDeColaborador;
use App\Models\Colaborador;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ActualizarColaboradorRequest extends FormRequest
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de un cambio parcial: cada campo se valida solo si viene.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');
        $colaborador = $this->route('colaborador');

        return [
            'nombre' => ['sometimes', 'string', 'max:60', Rule::unique('colaboradores', 'nombre')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($colaborador instanceof Colaborador ? $colaborador->id : null)],
            'horas_semanales' => ['sometimes', 'integer:strict', 'between:4,48'],
            'rol' => ['sometimes', Rule::enum(RolDeColaborador::class)],
            'activo' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
