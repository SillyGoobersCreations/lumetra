<?php

namespace App\Models;

use App\Services\ColorService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property string $id
 * @property string $title
 * @property string $organizer
 * @property string|null $logo
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $color_primary
 * @property string|null $color_secondary
 * @property int $confirmation_required
 * @property int $confirmation_personalized
 * @property int|null $room_slot_max_pending
 * @property int|null $room_slot_max_claimed
 * @property int $room_slot_team_confirmation_required
 * @property int|null $attendees_max
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendee> $attendees
 * @property-read int|null $attendees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventNote> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventRoom> $rooms
 * @property-read int|null $rooms_count
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAttendeesMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereColorPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereColorSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereConfirmationPersonalized($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereConfirmationRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereOrganizer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRoomSlotMaxClaimed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRoomSlotMaxPending($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRoomSlotTeamConfirmationRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @property string $state
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereState($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'state',
        'logo',
        'description',
        'start_date',
        'end_date',
        'color_primary',
        'confirmation_required',
        'confirmation_personalized',
        'confirmation_key',
        'email_from',
        'email_name',
        'room_slot_max_claims',
        'room_slot_min_time',
        'room_slot_max_time',
        'room_slot_team_confirmation_required',
        'attendees_max'
    ];

    protected $appends = [
        'swatch',
    ];

    protected $with = [
        'notes',
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

    public function getSwatchAttribute(): array {
        return ColorService::fromSwatch($this->color_primary);
    }

    public function getRemainingDaysAttribute()
    {
        if ($this->end_date) {
            $currentDate = Carbon::now();

            if (Carbon::parse($this->start_date)->isFuture()) {
                $currentDate = Carbon::parse($this->start_date);
            }

            $endDate = Carbon::parse($this->end_date);
            $remainingDays = $currentDate->diffInDays($endDate->addDay(), false);

            return max(ceil($remainingDays), 0);
        }
        return null;
    }
}
