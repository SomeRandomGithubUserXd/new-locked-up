<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class QuestChildTopic extends Model
{
    public $timestamps = false;

    protected $table = 'child_quest_topic';

    protected $fillable = ['name_ru', 'name_en', 'slug', 'active'];
}
