<?php

declare(strict_types=1);

namespace App\Enums;

enum Types: string
{
    case INSTANT = 'Instant';
    case SORCERY = 'Sorcery';
    case ARTIFACT = 'Artifact';
    case CREATURE = 'Creature';
    case ENCHANTMENT = 'Enchantment';
    case LAND = 'Land';
    case PLANE = 'Plane';
    case PLANESWALKER = 'Planeswalker';
    case CONSPIRACY = 'Conspiracy';
    case PHENOMENON = 'Phenomenon';
    case SCHEME = 'Scheme';
    case TRIBAL = 'Tribal';
    case VANGUARD = 'Vanguard';
}
