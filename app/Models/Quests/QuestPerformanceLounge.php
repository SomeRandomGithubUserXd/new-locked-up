<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class QuestPerformanceLounge extends Model
{
    protected $table = 'performance_lounge';

    protected $fillable = [
      'name_ru',
      'name_en',
      'description_ru',
      'description_en',
      'advantages_ru',
      'advantages_en',
    ];

    public $timestamps = false;
}
