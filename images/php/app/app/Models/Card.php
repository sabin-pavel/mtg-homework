<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $uuid
 * @property $name
 * @property $multiverseId
 * @property $layout
 * @property $manaCost
 * @property $cmc
 * @property $colors
 * @property $names
 * @property $type
 * @property $supertypes
 * @property $types
 * @property $subtypes
 * @property $rarity
 * @property $text
 * @property $flavor
 * @property $artist
 * @property $number
 * @property $power
 * @property $toughness
 * @property $loyalty
 * @property $variations
 * @property $watermark
 * @property $border
 * @property $isTimeShifted
 * @property $hand
 * @property $life
 * @property $isReserved
 * @property $releaseDate
 * @property $isStarter
 * @property $rulings
 * @property $foreignNames
 * @property $printings
 * @property $originalText
 * @property $originalType
 * @property $legalities
 * @property $source
 * @property $imageUrl
 * @property $set
 * @property $setName
 *
 * @method static Card create(array $attributes)
 * @method static Builder withUuid(...$params)
 */
class Card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'name',
        'multiverseId',
        'layout',
        'manaCost',
        'cmc',
        'colors',
        'names',
        'type',
        'supertypes',
        'subtypes',
        'types',
        'rarity',
        'text',
        'flavor',
        'artist',
        'number',
        'power',
        'toughness',
        'loyalty',
        'variations',
        'watermark',
        'border',
        'isTimeShifted',
        'hand',
        'life',
        'isReserved',
        'releaseDate',
        'isStarter',
        'rulings',
        'foreignNames',
        'printings',
        'originalText',
        'originalType',
        'legalities',
        'source',
        'imageUrl',
        'set',
        'setName',
    ];

    protected $casts = [
        'isTimeShifted' => 'boolean',
        'isReserved'    => 'boolean',
        'isStarter'     => 'boolean',
        'colors'        => 'array',
        'names'         => 'array',
        'supertypes'    => 'array',
        'types'         => 'array',
        'subtypes'      => 'array',
        'variations'    => 'array',
        'rulings'       => 'array',
        'foreignNames'  => 'array',
        'printings'     => 'array',
        'legalities'    => 'array',
    ];

    public function decks(): BelongsToMany
    {
        return $this->belongsToMany(
            Deck::class,
            'decks_cards',
            'card_uuid',
            'deck_id',
            'uuid',
            'id',
        );
    }

    public function scopeWithUuid(Builder $query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), ['deck_uuids' => $this->decks()->allRelatedIds()->toArray()]);
    }
}
