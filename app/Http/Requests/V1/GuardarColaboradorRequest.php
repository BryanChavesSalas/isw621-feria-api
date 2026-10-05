<?php

namespace App\Http\Requests\V1;

use App\Enums\RolDeColaborador;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GuardarColaboradorRequest extends FormRequest
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de un colaborador nuevo: el puesto llega en la ruta, no en el cuerpo.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');

        return [
            'nombre' => ['required', 'string', 'max:60', Rule::unique('colaboradores', 'nombre')->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)],
            'horas_semanales' => ['required', 'integer:strict', 'between:4,48'],
            'rol' => ['required', Rule::enum(RolDeColaborador::class)],
            'activo' => ['sometimes', 'boolean:strict'],
        ];
    }
}
