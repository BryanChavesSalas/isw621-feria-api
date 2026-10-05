<?php

namespace App\Http\Requests\V1;

use App\Enums\FranjaDeEntrega;
use App\Models\Apartado;
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
        $apartado = $this->route('apartado');

        return [
            'cliente' => ['sometimes', 'string', 'max:60', Rule::unique('apartados', 'cliente')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($apartado instanceof Apartado ? $apartado->id : null)],
            'cantidad' => ['sometimes', 'integer:strict', 'between:1,50'],
            'entrega' => ['sometimes', Rule::enum(FranjaDeEntrega::class)],
            'confirmado' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
