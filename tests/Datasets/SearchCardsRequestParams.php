<?php

use App\Enums\Color;
use App\Enums\Format;
use App\Enums\Layout;
use App\Enums\Legality;
use App\Enums\Rarity;
use App\Enums\Subtype;
use App\Enums\Supertype;
use App\Enums\Types;

dataset(
    'searchCards_with_valid_params',
    [
        'valid params' => [
            [
                'id'            => fake()->uuid,
                'name'          => $name = fake()->name,
                'multiverseid'  => fake()->numberBetween(1, 123123),
                'layout'        => $layout = fake()->randomElement(Layout::cases())->value,
                'cmc'           => fake()->numberBetween(1, 9),
                'colors'        => fake()->randomElement(Color::cases())->value,
                'colorIdentity' => substr(fake()->randomElement(Color::cases())->value, 0, 1),
                'supertypes'    => $supertype = fake()->randomElement(Supertype::cases())->value,
                'subtypes'      => $subtype = fake()->randomElement(Subtype::cases())->value,
                'types'         => $type = fake()->randomElement(Types::cases())->value,
                'type'          => $fullType = "$supertype $type — $subtype",
                'rarity'        => fake()->randomElement(Rarity::cases())->value,
                'text'          => fake()->text,
                'flavor'        => fake()->text,
                'artist'        => fake()->firstName . ' ' . fake()->lastName,
                'number'        => fake()->numberBetween(1, 9) . fake()->randomLetter,
                'power'         => fake()->numberBetween(1, 5) . fake()->randomElement(['+', '*', '']),
                'toughness'     => $type == Types::CREATURE->value
                    ? fake()->numberBetween(1, 5) . fake()->randomElement(['+', '*', ''])
                    : null,
                'loyalty'       => $type == Types::PLANESWALKER->value
                    ? fake()->randomElement([fake()->numberBetween(1, 9), 'X'])
                    : null,
                'variations'    => null,
                'watermark'     => null,
                'printings'     => [],
                'gameFormat'    => $gameFormat = fake()->randomElement(Format::cases())->value,
                'legality'      => $legality = fake()->randomElement(Legality::cases())->value,
                'imageUrl'      => null,
                'set'           => fake()->word,
                'setName'       => implode('|', fake()->words),
                'page'          => fake()->numberBetween(1, 10),
                'pageSize'      => fake()->numberBetween(1, 100),
            ]
        ],
    ]
);

dataset(
    'searchCards_with_invalid_params',
    [
        'invalid random: string' => [
            [
                'random' => fake()->word,
            ]
        ],
    ]
);

dataset(
    'searchCards_with_unknown_params',
    [
        'unknown param: no_worries' => [
            [
                'no_worries' => fake()->word,
            ]
        ],
    ]
);

