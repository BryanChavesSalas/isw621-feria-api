<?php

namespace App\Http\Requests\V1;

use App\Enums\FranjaDeEntrega;
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
            'cliente' => ['required', 'string', 'max:60', Rule::unique('apartados', 'cliente')->where('puesto_id', 
        $puesto instanceof Puesto ? $puesto->id : null)],
            'cantidad' => ['required', 'integer:strict', 'between:1,50'],
            'entrega' => ['required', Rule::enum(FranjaDeEntrega::class)],
            'confirmado' => ['sometimes', 'boolean:strict'],
        ];
    }
}
