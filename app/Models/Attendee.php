<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'handle',
        'first_name',
        'last_name',
        'avatar_url',
        'confirmed',
        'confirmation_key',
        'description',
        'job_company',
        'job_position',
        'role'
    ];

    protected $hidden = [
        'confirmation_key'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'id', 'event_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function contact_infos(): HasMany
    {
        return $this->hasMany(AttendeeContactInfo::class, 'attendee_id', 'id');
    }

    public function connections()
    {
        return AttendeeConnection::where('invitee_attendee_id', $this->id)
            ->orWhere('inviter_attendee_id', $this->id);
    }

    public function room_slot_claims()
    {
        return EventRoomSlotClaim::where('invitee_attendee_id', $this->id)
            ->orWhere('inviter_attendee_id', $this->id);
    }
}
