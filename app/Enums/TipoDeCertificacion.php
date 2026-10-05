<?php

namespace App\Enums;

/** Valores permitidos de jornada en las degustaciones. */
enum Jornada: string
{
    case Manana = 'manana';
    case Tarde = 'tarde';
}

enum TipoDeCertificacion: string
{
    case Organico = 'organico';
    case BuenasPracticas = 'buenas_practicas';
    case ComercioJusto = 'comercio_justo';
}
