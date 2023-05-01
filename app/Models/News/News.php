<?php

namespace App\Models\News;

use App\Models\Quests\Quest;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    use HasTimestamps;

    // TODO: Refactor when DB will be restructured
    protected $fillable = [
        0 => 'id',
        1 => 'alias',
        2 => 'image_path',
        3 => 'image_base_url',
        4 => 'published',
        5 => 'created_by',
        6 => 'updated_by',
        7 => 'created_at',
        8 => 'updated_at',
        9 => 'breadcrums_point_name',
        10 => 'og_img_path',
        11 => 'og_img_base_url',
        12 => 'og_type',
        13 => 'og_url',
        14 => 'title_ru',
        15 => 'title_en',
        16 => 'meta_title_ru',
        17 => 'meta_title_en',
        18 => 'og_title_ru',
        19 => 'og_title_en',
        20 => 'og_description_ru',
        21 => 'og_description_en',
        22 => 'announce_ru',
        23 => 'announce_en',
        24 => 'text_ru',
        25 => 'text_en',
        26 => 'h1_ru',
        27 => 'h1_en',
        28 => 'meta_description_ru',
        29 => 'meta_description_en',
        30 => 'meta_keywords_ru',
        31 => 'meta_keywords_en',
        32 => 'alias_en',
        33 => 'badge_ru',
        34 => 'badge_en',
        35 => 'conditions_text_ru',
        36 => 'conditions_text_en',
        37 => 'instruction_text_ru',
        38 => 'instruction_text_en',
        39 => 'book_button_link_ru',
        40 => 'book_button_link_en',
        41 => 'seo_text_ru',
        42 => 'seo_text_en',
        43 => 'quests_title_ru',
        44 => 'quests_title_en',
        45 => 'conditions_header_ru',
        46 => 'conditions_header_en',
        47 => 'book_button_text_ru',
        48 => 'book_button_text_en',
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
