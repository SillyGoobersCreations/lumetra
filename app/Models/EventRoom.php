<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(Event::class, 'id', 'event_id');
    }

    public function slots(): HasMany
    {
        return $this->hasMany(EventRoomSlot::class, 'event_room_id', 'id');
    }
}
