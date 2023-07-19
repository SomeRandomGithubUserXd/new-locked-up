<?php

namespace App\Http\Resources;

use App\Models\Orders\OrderOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Orders\OrderOption */
class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'is_active' => $this->is_active ? 'Да' : 'Нет',
            'name_ru' => $this->name_ru,
            'is_internal' => $this->is_internal ? 'Да' : 'Нет',
        ];
    }

    public static function singleItem(OrderOption $option): array
    {
        return [
            'id' => $option->id,
            'price' => $option->price,
            'is_active' => (bool) $option->is_active,
            'name_ru' => $option->name_ru,
            'name_en' => $option->name_en,
            'is_internal' => (bool) $option->is_internal,
        ];
    }
}
