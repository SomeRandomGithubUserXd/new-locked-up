<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class QuestPerformanceExperiment extends Model
{
    protected $table = 'performance_experiment';

    protected $fillable = [
        'name_ru',
        'name_en',
        'description_ru',
        'description_en',
        'full_description_ru',
        'full_description_en',
        'time_ru',
        'time_en',
        'price',
    ];

    public $timestamps = false;
}
