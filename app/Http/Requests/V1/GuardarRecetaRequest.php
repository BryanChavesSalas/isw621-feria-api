<?php

namespace App\Http\Requests\V1;

use App\Enums\Dificultad;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuardarRecetaRequest extends FormRequest
{
    /**
     * Determina si la persona puede hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación al crear una receta.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');

        return [
            'titulo' => ['required', 'string', 'max:80', Rule::unique('recetas', 'titulo')->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)],
            'minutos' => ['required', 'integer:strict', 'between:5,240'],
            'dificultad' => ['required', Rule::enum(Dificultad::class)],
            'publicada' => ['sometimes', 'boolean:strict'],
        ];
    }
}
