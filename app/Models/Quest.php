<?php

namespace App\Models;

use App\Models\Schedules\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quest extends Model
{
    protected $guarded = ['id'];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
