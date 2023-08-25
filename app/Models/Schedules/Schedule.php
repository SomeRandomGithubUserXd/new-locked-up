<?php

namespace App\Models\Schedules;

use App\Models\Quests\Quest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $fillable = ['name', 'date', 'og_title', 'og_description', 'og_type', 'og_url'];

    public function scheduleItems(): HasMany
    {
        return $this->hasMany(ScheduleItem::class)->orderBy('time');
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
