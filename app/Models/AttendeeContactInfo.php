<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->belongsTo(Attendee::class, 'id', 'attendee_id');
    }
}
