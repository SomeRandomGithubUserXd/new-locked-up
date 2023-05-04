<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class QuestPerformanceLoad extends Model
{
    protected $table = 'performance_package';

    public $timestamps = false;

    protected $fillable = [
        'quest_id',
        'name_ru',
        'name_en',
        'time',
        'price_workday',
        'price_weekend',
        'description_ru',
        'description_en',
        'class_name',
    ];
}
