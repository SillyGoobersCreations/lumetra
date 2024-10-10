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
 * @property string|null $notes
 * @property string|null $intro_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $inviter_attendee_id
 * @property string $invitee_attendee_id
 * @property-read \App\Models\Attendee|null $invitee_attendee
 * @property-read \App\Models\Attendee|null $inviter_attendee
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereIntroText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereInviteeAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereInviterAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeConnection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AttendeeConnection extends Model
{
    const STATE_PENDING = 'pending';
    const STATE_CONFIRMED = 'confirmed';
    const STATE_DECLINED = 'declined';

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
        return $this->belongsTo(Attendee::class, 'inviter_attendee_id', 'id');
    }

    public function invitee_attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'invitee_attendee_id', 'id');
    }

    public function scopeCheckConnection($query, $userAttendeeId, $attendeeId)
    {
        return $query->where(function ($query) use ($userAttendeeId, $attendeeId) {
            $query->where('inviter_attendee_id', $userAttendeeId)
                ->where('invitee_attendee_id', $attendeeId);
        })->orWhere(function ($query) use ($userAttendeeId, $attendeeId) {
            $query->where('inviter_attendee_id', $attendeeId)
                ->where('invitee_attendee_id', $userAttendeeId);
        });
    }
}
