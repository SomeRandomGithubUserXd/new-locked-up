<?php

namespace App\Http\Resources\News;

use App\Models\News\News;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\News\News */
class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'header' => $this->h1_ru,
            'alias' => $this->alias_ru,
            'is_published' => $this->is_published ? 'Да' : 'Нет',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public static function singleItem(News $news): array
    {
        return [
            'id' => $news->id,
            'meta_title_ru' => $news->meta_title_ru,
            'meta_title_en' => $news->meta_title_en,
            'meta_description_ru' => $news->meta_description_ru,
            'meta_description_en' => $news->meta_description_en,
            'meta_keywords_ru' => $news->meta_keywords_ru,
            'meta_keywords_en' => $news->meta_keywords_en,
            'og_title_ru' => $news->og_title_ru,
            'og_title_en' => $news->og_title_en,
            'og_type' => $news->og_type,
            'og_description_ru' => $news->og_description_ru,
            'og_description_en' => $news->og_description_en,
            'title_ru' => $news->title_ru,
            'title_en' => $news->title_en,
            'announce_ru' => $news->announce_ru,
            'announce_en' => $news->announce_en,
            'badge_ru' => $news->badge_ru,
            'badge_en' => $news->badge_en,
            'h1_ru' => $news->h1_ru,
            'h1_en' => $news->h1_en,
            'alias_ru' => $news->alias_ru,
            'alias_en' => $news->alias_en,
            'text_ru' => $news->text_ru,
            'text_en' => $news->text_en,
            'conditions_header_ru' => $news->conditions_header_ru,
            'conditions_header_en' => $news->conditions_header_en,
            'conditions_text_ru' => $news->conditions_text_ru,
            'conditions_text_en' => $news->conditions_text_en,
            'book_button_text_ru' => $news->book_button_text_ru,
            'book_button_text_en' => $news->book_button_text_en,
            'book_button_link_ru' => $news->book_button_link_ru,
            'book_button_link_en' => $news->book_button_link_en,
            'instruction_text_ru' => $news->instruction_text_ru,
            'instruction_text_en' => $news->instruction_text_en,
            'seo_text_ru' => $news->seo_text_ru,
            'seo_text_en' => $news->seo_text_en,
            'quests_title_ru' => $news->quests_title_ru,
            'quests_title_en' => $news->quests_title_en,
            'quest_ids' => [],
            'is_published' => (bool) $news->is_published,
            'quests_attached' => $news->quests->pluck('id'),
        ];
    }
}
