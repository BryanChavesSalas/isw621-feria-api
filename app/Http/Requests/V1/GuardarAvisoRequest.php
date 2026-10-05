<?php

namespace App\Http\Requests\V1;

use App\Enums\CategoriaDeAviso;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GuardarAvisoRequest extends FormRequest
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de un aviso nuevo: el puesto llega en la ruta, no en el cuerpo.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');

        return [
            'titulo' => ['required', 'string', 'max:80', Rule::unique('avisos', 'titulo')->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)],
            'dias_vigencia' => ['required', 'integer:strict', 'between:1,30'],
            'categoria' => ['required', Rule::enum(CategoriaDeAviso::class)],
            'activo' => ['sometimes', 'boolean:strict'],
        ];
    }
}
