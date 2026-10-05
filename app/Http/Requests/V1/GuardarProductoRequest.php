<?php

namespace App\Http\Requests\V1;

use App\Enums\Unidad;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GuardarProductoRequest extends FormRequest
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de un producto nuevo: el puesto llega en la ruta, no en el cuerpo.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');

        return [
            'nombre' => ['required', 'string', 'max:80', Rule::unique('productos', 'nombre')->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)],
            'precio_colones' => ['required', 'integer:strict', 'between:50,200000'],
            'unidad' => ['required', Rule::enum(Unidad::class)],
            'disponible' => ['sometimes', 'boolean:strict'],
        ];
    }
}
