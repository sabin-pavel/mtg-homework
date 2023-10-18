<?php

dataset(
    'createDeck_with_valid_params',
    [
        'valid params' =>  [
            [
                'name' => fake()->name,
                'description' => fake()->text
            ]
        ],
        'valid params: missing description' => [
            [
                'name' => fake()->name,
            ]
        ],
    ]
);

dataset(
    'createDeck_with_missing_name',
    [
        'invalid params: missing name' =>  [
            [
                'description' => fake()->text
            ]
        ],
    ]
);

dataset(
    'createDeck_with_invalid_name_type',
    [
        'invalid name: number' =>  [
            [
                'name' => fake()->numberBetween(0, 10),
            ]
        ],
        'invalid name: boolean' =>  [
            [
                'name' => fake()->boolean,
            ]
        ],
    ]
);


