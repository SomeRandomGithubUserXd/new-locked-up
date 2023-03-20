<?php

namespace App\Http\Resources\Quests;

use App\Models\Quests\Quest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Quests\Quest */
class QuestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name_ru,
            'order' => $this->ord,
            'views' => $this->hits_count,
            'is_active' => $this->activated,
        ];
    }

    public static function singleItem(Quest $quest): array
    {
        return [
            'ord' => $quest->ord ?? 0,
            'color' => $quest->color,
            'name_ru' => $quest->name_ru,
            'name_en' => $quest->name_en,
            'h1_ru' => $quest->h1_ru,
            'h1_en' => $quest->h1_en,
            'full_description_ru' => $quest->full_description_ru,
            'full_description_en' => $quest->full_description_en,
            'theme' => $quest->theme_id,
            'checkout_id' => $quest->checkout_type_id,
        ];
    }
}
