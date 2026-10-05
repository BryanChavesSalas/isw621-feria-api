<?php

namespace App\Http\Requests\V1;

use App\Enums\Jornada;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GuardarDegustacionRequest extends FormRequest
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de una degustación nueva: el puesto llega en la ruta, no en el cuerpo.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');

        return [
            'nombre' => ['required', 'string', 'max:60', Rule::unique('degustaciones', 'nombre')->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)],
            'porciones' => ['required', 'integer:strict', 'between:10,300'],
            'jornada' => ['required', Rule::enum(Jornada::class)],
            'activa' => ['sometimes', 'boolean:strict'],
        ];
    }
}
