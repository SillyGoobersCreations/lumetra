<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return $this->belongsTo(EventRoom::class, 'id', 'event_room_id');
    }

    public function claims(): HasOne
    {
        return $this->hasOne(EventRoomSlotClaim::class, 'event_room_slot_id', 'id');
    }
}
