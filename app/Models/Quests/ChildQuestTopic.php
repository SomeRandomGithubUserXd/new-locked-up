<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class ChildQuestTopic extends Model
{
    protected $fillable = [
        'name_ru',
        'name_en',
        'slug',
        'active',
    ];

    public $timestamps = false;
}
