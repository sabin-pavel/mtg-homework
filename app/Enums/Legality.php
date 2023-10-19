<?php

declare(strict_types=1);

namespace App\Enums;

enum Legality: string
{
    case LEGAL = 'Legal';
    case BANNED = 'Banned';
    case RESTRICTED = 'Restricted';
}
