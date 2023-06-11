<?php

namespace App\Http\Resources\Sale;

use App\Models\Sales\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Sales\Sale */
class SaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'promo_code' => $this->promocode,
            'value' => $this->value,
            'type' => $this->type->getName(),
            'best_before' => $this->best_before?->format('Y-m-d H:i:s'),
            'start_date' => $this->start_date?->format('Y-m-d H:i:s'),
            'weekdays_only' => $this->weekday_only ? 'Да' : 'Нет',
            'quest_list' => $this->quests->implode('name_ru', ', <br/>')
        ];
    }

    public static function singleItem(Sale $sale): array
    {
        return [
            'id' => $sale->id,
            'promo_code' => $sale->promocode,
            'value' => $sale->value,
            'type' => $sale->type,
            'start_date' => $sale->start_date?->format('Y-m-d'),
            'best_before' => $sale->best_before?->format('Y-m-d'),
            'weekdays_only' => (bool)$sale->weekday_only,
            'for_aggregators' => (bool)$sale->for_aggregators,
            'for_certificate' => (bool)$sale->for_certificate,
            'quest_ids' => $sale->quests->pluck('id')
        ];
    }
}
