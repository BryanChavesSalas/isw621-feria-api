<?php

namespace App\Http\Requests\V1;

use App\Enums\Unidad;
use App\Models\Producto;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ActualizarProductoRequest extends FormRequest
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
        $producto = $this->route('producto');

        return [
            'nombre' => ['sometimes', 'string', 'max:80', Rule::unique('productos', 'nombre')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($producto instanceof Producto ? $producto->id : null)],
            'precio_colones' => ['sometimes', 'integer:strict', 'between:50,200000'],
            'unidad' => ['sometimes', Rule::enum(Unidad::class)],
            'disponible' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
