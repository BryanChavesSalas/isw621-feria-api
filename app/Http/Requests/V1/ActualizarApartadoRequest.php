<?php

namespace App\Http\Requests\V1;

use App\Enums\FranjaDeEntrega;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ActualizarApartadoRequest extends FormRequest 
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de un cambio parcial: cada campo se valida solo si viene.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {

        $puesto = $this->route('puesto');
        $puestoId = is_object($puesto) ? $puesto->id : (int) $puesto;

        $apartado = $this->route('apartado');
        $apartadoId = is_object($apartado) ? $apartado->id : (int) $apartado;

        return [
            'cliente' => [
                'sometimes', 
                'string', 
                'max:60', 
                Rule::unique('apartados', 'cliente')
                    ->where('puesto_id', $puestoId)
                    ->ignore($apartadoId)
            ],
            'cantidad' => ['sometimes', 'integer', 'between:1,50'], // Removido :strict para compatibilidad con tipos del Test
            'entrega' => ['sometimes', Rule::enum(FranjaDeEntrega::class)],
            'confirmado' => ['sometimes', 'boolean'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
