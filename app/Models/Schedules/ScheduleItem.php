<?php

namespace App\Models\Schedules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleItem extends Model
{
    // Yeah...
    protected $table = 'shedule_item';

    protected $fillable = ['time', 'price', 'shedule_id', 'active', 'type'];

    public function shedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'shedule_id');
    }
}
