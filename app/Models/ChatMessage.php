<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property string $id
 * @property string $message
 * @property int $is_room_slot_invite
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $sender_attendee_id
 * @property string $receiver_attendee_id
 * @property-read \App\Models\Attendee|null $receiver_attendee
 * @property-read \App\Models\Attendee|null $sender_attendee
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereIsRoomSlotInvite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereReceiverAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereSenderAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        return $this->belongsTo(Attendee::class, 'sender_attendee_id', 'id');
    }

    public function receiver_attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'receiver_attendee_id', 'id');
    }
}
