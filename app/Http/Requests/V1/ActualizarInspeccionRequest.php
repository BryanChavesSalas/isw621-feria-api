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
        $inspeccion = $this->route('inspeccion');
        
        return [
            'acta' => ['sometimes', 'string', 'max:20', Rule::unique('inspecciones', 'acta')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($inspeccion instanceof Inspeccion ? $inspeccion->id : null)],
            'puntaje' => ['sometimes', 'integer:strict', 'between:0,100'],
            'resultado' => ['sometimes', Rule::enum(ResultadoDeInspeccion::class)],
            'publicada' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
