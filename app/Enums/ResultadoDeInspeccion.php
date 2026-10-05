<?php

namespace App\Enums;

/** Valores permitidos de jornada en las degustaciones. */
enum ResultadoDeInspeccion: string
{
    case Aprobada = 'aprobada';
    case ConObservaciones = 'con_observaciones';
    case Rechazada = 'rechazada';
}
