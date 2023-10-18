<?php

declare(strict_types=1);

namespace App\Enums;

enum Supertype: string
{
    case BASIC = 'Basic';
    case LEGENDARY = 'Legendary';
    case SNOW = 'Snow';
    case WORLD = 'World';
    case ONGOING = 'Ongoing';
}
