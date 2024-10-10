<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendeeNotification extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'attendee_id',
        'text',
        'link',
        'type'
    ];

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'attendee_id', 'id');
    }
}
