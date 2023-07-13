<?php

namespace App\Models\News;

use App\Models\Quests\Quest;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    use HasTimestamps;

    protected $fillable = [
        'alias_ru',
        'alias_en',
        'is_published',
        'title_ru',
        'title_en',
        'announce_ru',
        'announce_en',
        'text_ru',
        'text_en',
        'h1_ru',
        'h1_en',
        'meta_title_ru',
        'meta_title_en',
        'meta_description_ru',
        'meta_description_en',
        'meta_keywords_ru',
        'meta_keywords_en',
        'og_title_ru',
        'og_description_ru',
        'og_description_en',
        'badge_ru',
        'badge_en',
        'conditions_header_ru',
        'conditions_header_en',
        'conditions_text_ru',
        'conditions_text_en',
        'instruction_text_ru',
        'instruction_text_en',
        'book_button_link_ru',
        'book_button_link_en',
        'book_button_text_ru',
        'book_button_text_en',
        'seo_text_ru',
        'seo_text_en',
        'quests_title_ru',
        'quests_title_en',
    ];

    public function quests(): BelongsToMany
    {
        return $this->belongsToMany(
            Quest::class,
            'news_quests',
            'news_id',
            'quests_id',
        );
    }
}
