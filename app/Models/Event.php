<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'logo',
        'description',
        'start_date',
        'end_date',
        'color_primary',
        'color_secondary',
        'confirmation_required',
        'confirmation_personalized',
        'room_slot_max_claims',
        'room_slot_min_time',
        'room_slot_max_time',
        'room_slot_team_confirmation_required',
        'attendees_max'
    ];

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class, 'event_id', 'id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(EventRoom::class, 'event_id', 'id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(EventNote::class, 'event_id', 'id');
    }
}
