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
            'acta' => ['required', 'string', 'max:20', Rule::unique('inspecciones', 'acta')->where('puesto_id', $puesto 
        instanceof Puesto ? $puesto->id : null)],
            'puntaje' => ['required', 'integer:strict', 'between:0,100'],
            'resultado' => ['required', Rule::enum(ResultadoDeInspeccion::class)],
            'publicada' => ['sometimes', 'boolean:strict'],
        ];
    }
}
