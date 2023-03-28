<?php

namespace App\Http\Resources\Orders;

use App\Models\Orders\OrderSource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Orders\OrderSource */
class OrderSourceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public static function singleItem(OrderSource $orderSource): array
    {
        return [
            'id' => $orderSource->id,
            'name' => $orderSource->name,
            'aggregator' => (bool) $orderSource->aggregator,
            'color' => $orderSource->color,
        ];
    }
}
