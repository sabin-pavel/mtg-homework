<?php

namespace Database\Factories;

use App\Enums\Border;
use App\Enums\Color;
use App\Enums\Layout;
use App\Enums\Rarity;
use App\Enums\Subtype;
use App\Enums\Supertype;
use App\Enums\Types;
use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rulings = [];
        for ($i = 0; $i < fake()->numberBetween(0, 5); $i++) {
            $rulings[] = [
                'date' => fake()->date(),
                'text' => fake()->text,
            ];
        }

        $foreignNames = [];
        for ($i = 0; $i < fake()->numberBetween(0, 5); $i++) {
            $locale = fake()->locale;

            $foreignNames[] = [
                'name'         => fake($locale)->name,
                'language'     => fake($locale)->languageCode,
                'multiverseid' => fake($locale)->numberBetween(1, 182294),
            ];
        }

        return [
            'uuid'          => fake()->uuid,
            'name'          => $name = fake()->name,
            'multiverseId'  => fake()->numberBetween(1, 123123),
            'layout'        => $layout = fake()->randomElement(Layout::cases())->value,
            'manaCost'      => fake()->word,
            'colors'        => fake()->randomElement(Color::cases())->value,
            'colorIdentity' => substr(fake()->randomElement(Color::cases())->value, 0, 1),
            'names'         => [$name, fake()->name],
            'supertypes'    => [$supertype = fake()->randomElement(Supertype::cases())->value],
            'subtypes'      => [$subtype = fake()->randomElement(Subtype::cases())->value],
            'types'         => [$type = fake()->randomElement(Types::cases())->value],
            'type'          => $fullType = "$supertype $type — $subtype",
            'cmc'           => $type == Types::LAND->value ? 0 : fake()->numberBetween(1, 9),
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
                ? (string)fake()->randomElement([fake()->numberBetween(1, 9), 'X'])
                : null,
            'variations'    => null,
            'watermark'     => null,
            'border'        => fake()->randomElement(Border::cases())->value,
            'isTimeShifted' => fake()->boolean,
            'hand'          => $layout == Layout::VANGUARD->value
                ? fake()->randomElement(['+', '-']) . fake()->numberBetween(1, 5)
                : null,
            'life'          => $layout == Layout::VANGUARD->value
                ? fake()->randomElement(['+', '-']) . fake()->numberBetween(1, 5)
                : null,
            'isReserved'    => fake()->boolean,
            'releaseDate'   => fake()->date(),
            'isStarter'     => fake()->boolean,
            'rulings'       => $rulings,
            'foreignNames'  => $foreignNames,
            'printings'     => [],
            'originalText'  => fake()->text,
            'originalType'  => $fullType,
            'legalities'    => null,
            'source'        => fake()->word,
            'imageUrl'      => null,
            'set'           => fake()->word,
            'setName'       => fake()->word,
        ];
    }
}
