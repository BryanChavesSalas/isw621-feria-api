<?php

namespace App\Enums;

enum Canal: string
{
    case Presencial = 'presencial';
    case Whatsapp = 'whatsapp';
    case Web = 'web';
}