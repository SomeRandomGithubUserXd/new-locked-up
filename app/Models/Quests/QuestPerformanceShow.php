<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class QuestPerformanceShow extends Model
{
    protected $table = 'performance_show';

    public $timestamps = false;

    protected $fillable = [
        'quest_id',
        'name_ru',
        'name_en',
        'time_ru',
        'time_en',
        'description_ru',
        'description_en',
        'program_ru',
        'program_en',
    ];
}
