<?php

namespace App\Models\Lounges;

use App\Enums\ScheduleTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function time(): Attribute
    {
        return Attribute::make(
            get: static fn(string $value) => (new Carbon($value))->format('H:i')
        );
    }
}
