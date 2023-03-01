<?php

namespace App\Models;

use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Quest extends Model
{
    public function scheduleItems(): HasManyThrough
    {
        return $this->hasManyThrough(
            ScheduleItem::class,
            Schedule::class,
            'quest_id',
            'shedule_id'
        )->orderBy('time');
    }
}
