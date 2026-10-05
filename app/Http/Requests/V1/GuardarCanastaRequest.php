<?php

namespace App\Http\Requests\V1;

use App\Enums\TamanoDeCanasta;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GuardarCanastaRequest extends FormRequest
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de una canasta nueva: el puesto llega en la ruta, no en el cuerpo.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');

        return [
            'nombre' => ['required', 'string', 'max:60', Rule::unique('canastas', 'nombre')->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)],
            'precio_colones' => ['required', 'integer:strict', 'between:1000,100000'],
            'tamano' => ['required', Rule::enum(TamanoDeCanasta::class)],
            'disponible' => ['sometimes', 'boolean:strict'],
        ];
    }
}
