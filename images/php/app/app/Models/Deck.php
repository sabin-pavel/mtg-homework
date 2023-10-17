<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Uuid\Uuid;

/**
 * @property $id
 * @property $name
 * @property $multiverseId
 *
 * @method static create(array $attributes)
 * @method static Deck find(string $id)
 */
class Deck extends Model
{
    use HasUuids;

    const MAX_NUMBER_OF_CARDS_PER_DECK = 30;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function newUniqueId(): string
    {
        return (string)Uuid::uuid4();
    }

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(
            Card::class,
            'decks_cards',
            'deck_id',
            'card_uuid',
            'id',
            'uuid',
        );
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'card_uuids' => $this->cards()->allRelatedIds()->toArray(),
            'average_cmc' => round(
                $this->cards()->sum('cmc') / $this->cards()->where('type', '!=', 'Land')->count(),
                2
            ),
        ]);
    }
}
