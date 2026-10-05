<?php

namespace App\Http\Requests\V1;

use App\Enums\Dificultad;
use App\Models\Puesto;
use App\Models\Receta;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualizarRecetaRequest extends FormRequest
{
    /**
     * Determina si la persona puede hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación al actualizar una receta.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');
        $receta = $this->route('receta');

        return [
            'titulo' => ['sometimes', 'string', 'max:80', Rule::unique('recetas', 'titulo')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($receta instanceof Receta ? $receta->id : null)],
            'minutos' => ['sometimes', 'integer:strict', 'between:5,240'],
            'dificultad' => ['sometimes', Rule::enum(Dificultad::class)],
            'publicada' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
