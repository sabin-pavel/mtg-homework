<?php

declare(strict_types=1);

namespace App\Enums;

enum Rarity: string
{
    case BONUS = 'Bonus';
    case COMMON = 'Common';
    case MYTHIC_RARE = 'Mythic Rare';
    case RARE = 'Rare';
    case SPECIAL = 'Special';
    case UNCOMMON = 'Uncommon';
    case BASIC_LAND = 'Basic Land';
}
