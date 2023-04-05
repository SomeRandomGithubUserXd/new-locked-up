<?php

namespace App\Models\Lounges;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lounge extends Model
{
    protected $fillable = [
        'name_ru', 'name_en', 'is_active', 'lounge_schedule_id'
    ];

    public function loungeSchedule(): BelongsTo
    {
        return $this->belongsTo(LoungeSchedule::class);
    }
}
