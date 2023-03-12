<?php

namespace App\Http\Resources\Quests;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Quest */
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
}
