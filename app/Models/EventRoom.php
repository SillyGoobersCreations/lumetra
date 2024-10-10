<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string|null $location
 * @property string|null $notes
 * @property int $available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_id
 * @property-read \App\Models\Event|null $event
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventRoomSlot> $slots
 * @property-read int|null $slots_count
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoom whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventRoom extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'location',
        'notes',
        'available',
        'event_id'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function slots(): HasMany
    {
        return $this->hasMany(EventRoomSlot::class, 'event_room_id', 'id');
    }
}
