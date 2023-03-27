<?php

namespace App\Models\Schedules;

use App\Enums\ScheduleTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleItem extends Model
{
    // Yeah...
    protected $table = 'shedule_item';

    protected $fillable = ['time', 'price', 'shedule_id', 'active', 'type'];

    public $timestamps = false;

    protected $casts = [
        'type' => ScheduleTypeEnum::class
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'shedule_id');
    }

    public function active(): Attribute
    {
        // Cast to bool
        return Attribute::make(
            get: static fn(bool $value) => $value
        );
    }
}
