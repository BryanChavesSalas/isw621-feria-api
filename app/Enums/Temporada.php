<?php

namespace App\Enums;

/** Valores permitidos de temporada en las cosechas. */
enum Temporada: string
{
    case Seca = 'seca';
    case Lluviosa = 'lluviosa';
    case TodoElAno = 'todo_el_ano';
}
