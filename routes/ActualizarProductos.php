<?php

$puesto = $this->route('puesto');
$producto = $this->route('producto');
return [
 'nombre' => ['sometimes', 'string', 'max:80', Rule::unique('productos', 'nombre')
 ->where('puesto_id', $puesto instanceof Puesto ? $puesto->id : null)
 ->ignore($producto instanceof Producto ? $producto->id : null)],
 'precio_colones' => ['sometimes', 'integer:strict', 'between:50,200000'],
 'unidad' => ['sometimes', Rule::enum(Unidad::class)],
 'disponible' => ['sometimes', 'boolean:strict'],
 'puesto_id' => ['prohibited'],
];
