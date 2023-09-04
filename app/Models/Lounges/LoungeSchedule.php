<?php

namespace App\Models\Lounges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoungeSchedule extends Model
{
    protected $fillable = [
        'name'
    ];

    public function lounge(): HasMany
    {
        return $this->hasMany(Lounge::class);
    }

    public function loungeScheduleItems(): HasMany
    {
        return $this->hasMany(LoungeScheduleItem::class, 'lounge_schedule_id')->where(['type' => 'weekdays']);
    }
}
