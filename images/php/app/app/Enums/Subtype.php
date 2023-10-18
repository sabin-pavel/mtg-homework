<?php

declare(strict_types=1);

namespace App\Enums;

enum Subtype: string
{
    case TRAP = 'Trap';
    case ARCANE = 'Arcane';
    case EQUIPMENT = 'Equipment';
    case AURA = 'Aura';
    case HUMAN = 'Human';
    case RAT = 'Rat';
    case SQUIRREL = 'Squirrel';
    case ANGEL = 'Angel';
}
