<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class QuestTopic extends Model
{
    protected $table = 'quests_topics';

    public $timestamps = false;

    protected $fillable = [
        'active',
        'alias',
        'og_type',
        'og_url',
        'name_ru',
        'name_en',
        'og_title_ru',
        'og_title_en',
        'og_description_ru',
        'og_description_en',
        'h1_ru',
        'h1_en',
        'title_ru',
        'title_en',
        'seo_ru',
        'seo_en',
        'description_ru',
        'description_en',
        'keywords_ru',
        'keywords_en',
        'position',
    ];
}
