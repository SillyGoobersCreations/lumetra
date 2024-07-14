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
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_room_slot_id
 * @property string $inviter_attendee_id
 * @property string $invitee_attendee_id
 * @property-read \App\Models\Attendee|null $invitee_attendee
 * @property-read \App\Models\Attendee|null $inviter_attendee
 * @property-read \App\Models\EventRoomSlot|null $slot
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereEventRoomSlotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereInviteeAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereInviterAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRoomSlotClaim whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventRoomSlotClaim extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'state',
        'event_room_slot_id',
        'inviter_attendee_id',
        'invitee_attendee_id',
    ];

    public function slot(): BelongsTo
    {
        return $this->belongsTo(EventRoomSlot::class, 'event_room_slot_id', 'id');
    }

    public function inviter_attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'inviter_attendee_id', 'id');
    }

    public function invitee_attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'invitee_attendee_id', 'id');
    }
}
