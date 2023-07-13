<?php

namespace App\Models\Schedules;

use App\Enums\ScheduleTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleItem extends Model
{
    protected $fillable = ['time', 'price', 'schedule_id', 'active', 'type'];

    protected $casts = [
        'type' => ScheduleTypeEnum::class
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function active(): Attribute
    {
        // Cast to bool
        return Attribute::make(
            get: static fn(bool $value) => $value
        );
    }
}
