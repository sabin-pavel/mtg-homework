<?php

declare(strict_types=1);

namespace App\Enums;

enum Layout: string
{
    case NORMAL = 'normal';
    case SPLIT = 'split';
    case FLIP = 'flip';
    case DOUBLE_FACED = 'double-faced';
    case TOKEN = 'token';
    case PLANE = 'plane';
    case SCHEME = 'scheme';
    case PHENOMENON = 'phenomenon';
    case LEVELER = 'leveler';
    case VANGUARD = 'vanguard';
    case AFTERMATH = 'aftermath';
}
