<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class ChildQuestTopic extends Model
{
    protected $table = 'child_quest_topic';

    protected $fillable = [
        'name_ru',
        'name_en',
        'slug',
        'active',
    ];

    public $timestamps = false;
}
