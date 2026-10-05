<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

$puesto = $this->route('puesto');
return [
 'nombre' => ['required', 'string', 'max:80', Rule::unique('productos', 'nombre')->where('puesto_id', $puesto
instanceof Puesto ? $puesto->id : null)],
 'precio_colones' => ['required', 'integer:strict', 'between:50,200000'],
 'unidad' => ['required', Rule::enum(Unidad::class)],
 'disponible' => ['sometimes', 'boolean:strict'],
];


