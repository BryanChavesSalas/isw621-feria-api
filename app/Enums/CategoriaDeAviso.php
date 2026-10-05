<?php

namespace App\Enums;

/** Valores permitidos de jornada en las degustaciones. */
enum CategoriaDeAviso: string
{
    case Horario = 'horario';
    case Precio = 'precio';
    case Producto = 'producto';
    case General = 'general';
}
