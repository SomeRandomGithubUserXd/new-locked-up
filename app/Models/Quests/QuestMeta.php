<?php

namespace App\Models\Quests;

use Illuminate\Database\Eloquent\Model;

class QuestMeta extends Model
{
    protected $fillable = [
        'quest_id',
        'rating',
        'short_description_ru',
        'short_description_en',
        'full_description_ru',
        'full_description_en',
        'subway_station_ru',
        'subway_station_en',
        'genre_ru',
        'genre_en',
        'schedule_text_ru',
        'schedule_text_en',
        'text_above_schedule_ru',
        'text_above_schedule_en',
        'text_below_schedule_ru',
        'text_below_schedule_en',
        'page_title_ru',
        'page_title_en',
        'h1_ru',
        'h1_en',
        'page_description_ru',
        'page_description_en',
        'page_keywords_ru',
        'page_keywords_en',
        'options_block_header',
        'options_block_subheading',
        'you_may_like_it_section_header',
        'you_may_like_it_section_subheading',
        'schedule_blocks_section_header',
        'schedule_section_blocks_bottom_text',
        'og_title',
        'og_description',
        'og_type',
        'og_url',
    ];
}
