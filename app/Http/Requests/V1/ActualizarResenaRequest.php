<?php

namespace App\Http\Requests\V1;

use App\Enums\Canal;
use App\Models\Puesto;
use App\Models\Resena;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualizarResenaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $puesto = $this->route('puesto');
        $resena = $this->route('resena');

        return [
            'autor' => [
                'sometimes',
                'string',
                'max:40',
                Rule::unique('resenas', 'autor')
                    ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
                    ->ignore($resena instanceof Resena ? $resena->id : null),
            ],
            'calificacion' => [
                'sometimes',
                'integer:strict',
                'between:1,5',
            ],
            'canal' => [
                'sometimes',
                Rule::enum(Canal::class),
            ],
            'visible' => [
                'sometimes',
                'boolean:strict',
            ],
            'puesto_id' => [
                'prohibited',
            ],
        ];
    }
}
