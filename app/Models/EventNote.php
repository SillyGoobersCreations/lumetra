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
 * @property string $title
 * @property string $text
 * @property int $sticky
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $event_id
 * @property-read \App\Models\Event|null $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereSticky($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventNote whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
