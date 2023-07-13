<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class QuestTopic extends Model
{
    protected $fillable = [
        'name_ru',
        'name_en',
        'alias',
        'h1_ru',
        'h1_en',
        'title_ru',
        'title_en',
        'description_ru',
        'description_en',
        'og_title_ru',
        'og_title_en',
        'og_description_ru',
        'og_description_en',
        'og_type',
        'og_url',
        'seo_ru',
        'seo_en',
        'keywords_ru',
        'keywords_en',
        'ord',
        'is_active',
    ];
}
