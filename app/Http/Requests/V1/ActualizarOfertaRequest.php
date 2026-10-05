<?php

namespace App\Http\Requests\V1;

use App\Enums\Jornada;
use App\Models\Degustacion;
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
        $oferta = $this->route('oferta');
 
        return [
    'titulo' => ['sometimes', 'string', 'max:60', Rule::unique('ofertas', 'titulo')
        ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
        ->ignore($oferta instanceof Oferta ? $oferta->id : null)],
    'descuento_porcentaje' => ['sometimes', 'integer:strict', 'between:5,50'],
    'tipo' => ['sometimes', Rule::enum(TipoDeOferta::class)],
    'vigente' => ['sometimes', 'boolean:strict'],
    'puesto_id' => ['prohibited'],
 ];

    }
}
