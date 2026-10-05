<?php

namespace App\Http\Requests\V1;

use App\Enums\CategoriaDeAviso;
use App\Models\Aviso;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ActualizarAvisoRequest extends FormRequest
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
        $aviso = $this->route('aviso');

        return [
            'titulo' => ['sometimes', 'string', 'max:80', Rule::unique('avisos', 'titulo')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($aviso instanceof Aviso ? $aviso->id : null)],
            'dias_vigencia' => ['sometimes', 'integer:strict', 'between:1,30'],
            'categoria' => ['sometimes', Rule::enum(CategoriaDeAviso::class)],
            'activo' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
