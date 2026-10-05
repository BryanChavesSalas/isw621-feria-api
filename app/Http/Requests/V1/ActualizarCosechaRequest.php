<?php

namespace App\Http\Requests\V1;

use App\Enums\Temporada;
use App\Models\Cosecha;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ActualizarCosechaRequest extends FormRequest
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
        $cosecha = $this->route('cosecha');

        return [
            'cultivo' => ['sometimes', 'string', 'max:60', Rule::unique('cosechas', 'cultivo')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($cosecha instanceof Cosecha ? $cosecha->id : null)],
            'kilos_estimados' => ['sometimes', 'integer:strict', 'between:1,5000'],
            'temporada' => ['sometimes', Rule::enum(Temporada::class)],
            'confirmada' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
