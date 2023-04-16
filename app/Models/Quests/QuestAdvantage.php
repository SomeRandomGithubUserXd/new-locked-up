<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestAdvantage extends Model
{
    public $timestamps = false;

    protected $fillable = ['name_ru', 'description_ru'];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
