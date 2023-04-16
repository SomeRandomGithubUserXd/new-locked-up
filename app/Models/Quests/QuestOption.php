<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestOption extends Model
{
    protected $table = 'quest_option';

    public $timestamps = false;

    protected $fillable = ['name_ru'];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
