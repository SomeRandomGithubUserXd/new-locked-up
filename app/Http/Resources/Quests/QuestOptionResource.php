<?php

namespace App\Http\Resources\Quests;

use App\Http\Resources\BookingQuestResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Quests\QuestOption */
class QuestOptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'header' => $this->name_ru,
        ];
    }
}
