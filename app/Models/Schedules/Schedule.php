<?php

namespace App\Models\Schedules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    // Damn...
    protected $table = 'shedule';

    protected $fillable = ['name', 'quest_id', 'date', 'og_title', 'og_description', 'og_img_path', 'og_img_base_url', 'og_type', 'og_url'];

    public static string $weekdaysScheduleType = 'weekdays';

    public static string $fridayScheduleType = 'friday';

    public static string $weekendScheduleType = 'weekend';

    public function scheduleItems(): HasMany
    {
        return $this->hasMany(ScheduleItem::class, 'shedule_id')->orderBy('time');
    }
}
