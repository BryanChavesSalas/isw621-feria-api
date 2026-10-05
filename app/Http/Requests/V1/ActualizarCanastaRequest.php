<?php

namespace App\Http\Requests\V1;

use App\Enums\TamanoDeCanasta;
use App\Models\Canasta;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ActualizarCanastaRequest extends FormRequest
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de una actualización parcial: cada campo se valida solo si viene.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');
        $canasta = $this->route('canasta');

        return [
            'nombre' => ['sometimes', 'string', 'max:60', Rule::unique('canastas', 'nombre')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($canasta instanceof Canasta ? $canasta->id : null)],
            'precio_colones' => ['sometimes', 'integer:strict', 'between:1000,100000'],
            'tamano' => ['sometimes', Rule::enum(TamanoDeCanasta::class)],
            'disponible' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
