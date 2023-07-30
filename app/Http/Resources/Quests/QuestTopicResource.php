<?php

namespace App\Http\Resources\Quests;

use App\Http\Controllers\Quests\ChildQuestTopicController;
use App\Models\Quests\ChildQuestTopic;
use App\Models\Quests\QuestTopic;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Quests\QuestTopic */
class QuestTopicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name_ru
        ];
    }

    public static function singleItem(QuestTopic $topic): array
    {
        return [
            'id' => $topic->id,
            'is_active' => (bool)$topic->is_active,
            'name_ru' => $topic->name_ru,
            'name_en' => $topic->name_en,
            'title_ru' => $topic->title_ru,
            'title_en' => $topic->title_en,
            'description_ru' => $topic->description_ru,
            'description_en' => $topic->description_en,
            'keywords_ru' => $topic->keywords_ru,
            'keywords_en' => $topic->keywords_en,
            'og_title_ru' => $topic->og_title_ru,
            'og_title_en' => $topic->og_title_en,
            'og_description_ru' => $topic->og_description_ru,
            'og_description_en' => $topic->og_description_en,
            'og_type' => $topic->og_type,
            'og_url' => $topic->og_url,
            'alias' => $topic->alias,
            'ord' => $topic->ord,
            'seo_ru' => $topic->seo_ru,
            'seo_en' => $topic->seo_en,
            'h1_ru' => $topic->h1_ru,
            'h1_en' => $topic->h1_en,
        ];
    }

    public static function singleChildItem(ChildQuestTopic $topic): array
    {
        return [
            'id' => $topic->id,
            'is_active' => (bool)$topic->is_active,
            'name_ru' => $topic->name_ru,
            'name_en' => $topic->name_en,
        ];
    }
}
