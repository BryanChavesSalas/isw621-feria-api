<?php

namespace App\Http\Requests\V1;

use App\Enums\TipoDeCertificacion;
use App\Models\Certificacion;
use App\Models\Puesto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ActualizarCertificacionRequest extends FormRequest
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
        $certificacion = $this->route('certificacion');

        return [
            'nombre' => ['sometimes', 'string', 'max:80', Rule::unique('certificaciones', 'nombre')
                ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                ->ignore($certificacion instanceof Certificacion ? $certificacion->id : null)],
            'vigencia_meses' => ['sometimes', 'integer:strict', 'between:1,36'],
            'tipo' => ['sometimes', Rule::enum(TipoDeCertificacion::class)],
            'verificada' => ['sometimes', 'boolean:strict'],
            'puesto_id' => ['prohibited'],
        ];
    }
}
