<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 *
 * @property string $id
 * @property string $start_date
 * @property string $end_date
 * @property string|null $notes
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_room_id
 * @property-read \App\Models\EventRoomSlotClaim|null $claims
 * @property-read \App\Models\EventRoom|null $room
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereEventRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventRoomSlot extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'start_date',
        'end_date',
        'notes',
        'state',
        'event_id'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(EventRoom::class, 'event_room_id', 'id');
    }

    public function claims(): HasOne
    {
        return $this->hasOne(EventRoomSlotClaim::class, 'event_room_slot_id', 'id');
    }
}
