<?php

namespace App\Enums;

/** Valores permitidos de jornada en las degustaciones. */
enum FranjaDeEntrega: string
{
   case SabadoManana = 'sabado_manana';
    case SabadoTarde = 'sabado_tarde';
    case DomingoManana = 'domingo_manana';
}
