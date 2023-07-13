<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class QuestLoad extends Model
{
    protected $fillable = [
        'page_id',
        'title_ru',
        'title_en',
        'price_ru',
        'price_en',
        'services_ru',
        'services_en',
        'advantages_ru',
        'advantages_en',
        'button_text_ru',
        'button_text_en',
        'is_hidden',
        'title_fdp_ru',
        'title_fdp_en',
        'type_fdp_ru',
        'type_fdp_en',
        'description_fdp_ru',
        'description_fdp_en',
        'short_description_fdp_ru',
        'short_description_fdp_en',
        'text_ru',
        'text_en',
        'price_weekend_ru',
        'price_weekend_en',
        'ord',

    ];
}
