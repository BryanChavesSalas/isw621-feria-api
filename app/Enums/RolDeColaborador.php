<?php

namespace App\Enums;

/** Valores permitidos de rol en los colaboradores. */
enum RolDeColaborador: string
{
    case Vendedor = 'vendedor';
    case Cajero = 'cajero';
    case Cargador = 'cargador';
}
