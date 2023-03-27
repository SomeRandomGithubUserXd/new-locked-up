<?php

namespace App\Models\Schedules;

use App\Models\Quests\Quest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    // Damn...
    protected $table = 'shedule';

    public $timestamps = false;

    protected $fillable = ['name', 'quest_id', 'date', 'og_title', 'og_description', 'og_img_path', 'og_img_base_url', 'og_type', 'og_url'];

    public function scheduleItems(): HasMany
    {
        return $this->hasMany(ScheduleItem::class, 'shedule_id')->orderBy('time');
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
