<?php

namespace App\Http\Requests\V1;

use App\Enums\TipoDeCertificacion;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GuardarCertificacionRequest extends FormRequest
{
    /** En esta prueba no hay autenticación. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de una certificación nueva: el puesto llega en la ruta, no en el cuerpo.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');

        return [
            'nombre' => ['required', 'string', 'max:80', Rule::unique('certificaciones', 'nombre')->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)],
            'vigencia_meses' => ['required', 'integer:strict', 'between:1,36'],
            'tipo' => ['required', Rule::enum(TipoDeCertificacion::class)],
            'verificada' => ['sometimes', 'boolean:strict'],
        ];
    }
}
