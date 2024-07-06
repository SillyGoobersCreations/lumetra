<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property string $id
 * @property string $handle
 * @property string $first_name
 * @property string $last_name
 * @property string|null $avatar_url
 * @property int $confirmed
 * @property string|null $confirmation_key
 * @property string|null $description
 * @property string|null $job_company
 * @property string|null $job_position
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_id
 * @property string $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttendeeContactInfo> $contact_infos
 * @property-read int|null $contact_infos_count
 * @property-read \App\Models\Event|null $event
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereConfirmationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereHandle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereJobCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereJobPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendee whereUserId($value)
 * @mixin \Eloquent
 */
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
