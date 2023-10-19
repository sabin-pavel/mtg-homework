<?php

declare(strict_types=1);

namespace App\Enums;

enum Format: string
{
    case AMONKHET_BLOCK = "Amonkhet Block";
    case BATTLE_FOR_ZENDIKAR_BLOCK = "Battle for Zendikar Block";
    case CLASSIC = "Classic";
    case COMMANDER = "Commander";
    case EXTENDED = "Extended";
    case FREEFORM = "Freeform";
    case ICE_AGE_BLOCK = "Ice Age Block";
    case INNISTRAD_BLOCK = "Innistrad Block";
    case INVASION_BLOCK = "Invasion Block";
    case KALADESH_BLOCK = "Kaladesh Block";
    case KAMIGAWA_BLOCK = "Kamigawa Block";
    case KHANS_OF_TARKIR_BLOCK = "Khans of Tarkir Block";
    case LEGACY = "Legacy";
    case LORWYN_SHADOWMOOR_BLOCK = "Lorwyn-Shadowmoor Block";
    case MASQUES_BLOCK = "Masques Block";
    case MIRAGE_BLOCK = "Mirage Block";
    case MIRRODIN_BLOCK = "Mirrodin Block";
    case MODERN = "Modern";
    case ODYSSEY_BLOCK = "Odyssey Block";
    case ONSLAUGHT_BLOCK = "Onslaught Block";
    case PRISMATIC = "Prismatic";
    case RAVNICA_BLOCK = "Ravnica Block";
    case RETURN_TO_RAVNICA_BLOCK = "Return to Ravnica Block";
    case SCARS_OF_MIRRODIN_BLOCK = "Scars of Mirrodin Block";
    case SHADOWS_OVER_INNISTRAD_BLOCK = "Shadows over Innistrad Block";
    case SHARDS_OF_ALARA_BLOCK = "Shards of Alara Block";
    case SINGLETON_100 = "Singleton 100";
    case STANDARD = "Standard";
    case TEMPEST_BLOCK = "Tempest Block";
    case THEROS_BLOCK = "Theros Block";
    case TIME_SPIRAL_BLOCK = "Time Spiral Block";
    case TRIBAL_WARS_LEGACY = "Tribal Wars Legacy";
    case UN_SETS = "Un-Sets";
    case URZA_BLOCK = "Urza Block";
    case VINTAGE = "Vintage";
    case ZENDIKAR_BLOCK = "Zendikar Block";
}
