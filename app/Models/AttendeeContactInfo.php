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
 * @property string $type
 * @property string $value
 * @property string $visibility
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $attendee_id
 * @property-read \App\Models\Attendee|null $attendee
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereAttendeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendeeContactInfo whereVisibility($value)
 * @mixin \Eloquent
 */
class AttendeeContactInfo extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'attendee_id',
        'type',
        'value',
        'visibility',
    ];

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'attendee_id', 'id');
    }
}
