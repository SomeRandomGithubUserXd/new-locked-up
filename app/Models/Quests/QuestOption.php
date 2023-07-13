<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestOption extends Model
{
    protected $fillable = [
        'quest_id',
        'name_ru',
        'name_en',
        'description_ru',
        'description_en',
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
