<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventNote extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'text',
        'sticky',
        'event_id',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'id', 'event_id');
    }
}
