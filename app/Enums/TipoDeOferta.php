<?php

namespace App\Enums;

/** Valores permitidos de jornada en las degustaciones. */
enum TipoDeOferta: string
{
    case PorUnidad = 'por_unidad';
    case PorKilo = 'por_kilo';
    case Combo = 'combo';
}

