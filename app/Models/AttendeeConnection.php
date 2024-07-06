<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendeeConnection extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'state',
        'inviter_attendee_id',
        'invitee_attendee_id',
        'notes',
        'intro_text'
    ];

    public function inviter_attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'id', 'inviter_attendee_id');
    }

    public function invitee_attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'id', 'invitee_attendee_id');
    }
}
