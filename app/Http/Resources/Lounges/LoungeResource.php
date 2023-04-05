<?php

namespace App\Http\Resources\Lounges;

use App\Models\Lounges\Lounge;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Lounges\Lounge */
class LoungeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_ru' => $this->name_ru,
            'name_en' => $this->name_en,
            'is_active' => $this->is_active ? 'Да' : 'Нет',
            'lounge_schedule_id' => $this->lounge_schedule_id
        ];
    }

    public static function singleItem(Lounge $lounge): array
    {
        return [
            'id' => $lounge->id,
            'name_ru' => $lounge->name_ru,
            'name_en' => $lounge->name_en,
            'is_active' => (bool) $lounge->is_active,
            'lounge_schedule_id' => $lounge->lounge_schedule_id
        ];
    }
}
