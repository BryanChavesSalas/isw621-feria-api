<?php

namespace App\Http\Requests\V1;

use App\Enums\Temporada;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GuardarCosechaRequest extends FormRequest
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de una cosecha nueva: el puesto llega en la ruta, no en el cuerpo.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');

        return [
            'cultivo' => ['required', 'string', 'max:60', Rule::unique('cosechas', 'cultivo')->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)],
            'kilos_estimados' => ['required', 'integer:strict', 'between:1,5000'],
            'temporada' => ['required', Rule::enum(Temporada::class)],
            'confirmada' => ['sometimes', 'boolean:strict'],
        ];
    }
}
