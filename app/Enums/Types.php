<?php

declare(strict_types=1);

namespace App\Enums;

enum Types: string
{
    case ARTIFACT = 'Artifact';
    case CONSPIRACY = 'Conspiracy';
    case CREATURE = 'Creature';
    case ENCHANTMENT = 'Enchantment';
    case INSTANT = 'Instant';
    case LAND = 'Land';
    case PHENOMENON = 'Phenomenon';
    case PLANE = 'Plane';
    case PLANESWALKER = 'Planeswalker';
    case SCHEME = 'Scheme';
    case SORCERY = 'Sorcery';
    case TRIBAL = 'Tribal';
    case VANGUARD = 'Vanguard';
}
