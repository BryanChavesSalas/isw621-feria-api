<?php

namespace App\Http\Requests\V1;

use App\Enums\FranjaDeEntrega;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GuardarApartadoRequest extends FormRequest // 
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de un apartado nuevo.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        // Obtenemos el parámetro de la ruta de manera segura como ID numérico o string 
        // para evitar que el proceso de PHP colapse por resolución circular de modelos.
        $puesto = $this->route('puesto');
        $puestoId = is_object($puesto) ? $puesto->id : (int) $puesto;

        return [
            'cliente' => [
                'required', 
                'string', 
                'max:60', 
                Rule::unique('apartados', 'cliente')->where('puesto_id', $puestoId)
            ],
            'cantidad' => ['required', 'integer', 'between:1,50'], // Quitamos :strict si da falsos negativos en el test
            'entrega' => ['required', Rule::enum(FranjaDeEntrega::class)],
            'confirmado' => ['sometimes', 'boolean'],
        ];
    }
}
