<?php

namespace App\Models\Lounges;

use App\Enums\ScheduleTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoungeScheduleItem extends Model
{
    protected $fillable = [
        'lounge_schedule_id', 'time', 'price', 'type'
    ];

    protected $casts = [
        'type' => ScheduleTypeEnum::class
    ];

    public function loungeSchedule(): BelongsTo
    {
        return $this->belongsTo(LoungeSchedule::class);
    }
}
