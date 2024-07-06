<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'message',
        'sender_attendee_id',
        'receiver_attendee_id',
        'is_room_slot_invite'
    ];

    public function sender_attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'id', 'sender_attendee_id');
    }

    public function receiver_attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'id', 'receiver_attendee_id');
    }
}
