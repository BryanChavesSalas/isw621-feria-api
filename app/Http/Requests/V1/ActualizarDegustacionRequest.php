<?php

namespace App\Http\Requests\V1;

use App\Enums\Jornada;
use App\Models\Degustacion;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ActualizarDegustacionRequest extends FormRequest
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
        $degustacion = $this->route('degustacion');

        return [
            'nombre' => ['sometimes', 'string', 'max:60', Rule::unique('degustaciones', 'nombre')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($degustacion instanceof Degustacion ? $degustacion->id : null)],
            'porciones' => ['sometimes', 'integer:strict', 'between:10,300'],
            'jornada' => ['sometimes', Rule::enum(Jornada::class)],
            'activa' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
