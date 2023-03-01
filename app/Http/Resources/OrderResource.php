<?php

namespace App\Http\Resources;

use App\Models\Certificate;
use App\Models\Orders\Order;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Orders\Order */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quest' => $this->quest->name_ru,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'created_at' => $this->created_at->format('d/m/Y'),
            'date' => $this->date->format('d/m/Y H:i:s'),
            'source' => $this->source,
            'status' => $this->status,
            'comment' => $this->comment,
            'fact_payment' => $this->fact_payment,
            'price_total' => $this->price_total,
            'sources' => $this->sources
        ];
    }

    public static function singleItem(Order $order): array
    {
        return [
            'id' => $order->id,
            'quest_id' => $order->quest_id,
            'players_count' => $order->countPlayers,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'created_at' => $order->created_at->format('d/m/Y'),
            'date' => $order->date->format('Y-m-d'),
            'time' => $order->date->format('H:i'),
            'source' => $order->source,
            'promo_code' => Sale::firstWhere(['promocode' => $order->promo, 'is_deleted' => 0]),
            'certificate' => Certificate::find($order->certificate_data_id),
            'comment' => $order->comment,
            'fact_payment' => $order->fact_payment,
            'pre_payed' => $order->prepayed,
            'online_payment' => $order->payed_online,
            'payed_aggregator' => $order->payed_aggregator,
            'price_total' => $order->price_total,
            'option' => $order->package,
            'sources' => $order->sources,
            'options' => $order->orderOptions->makeHidden('pivot')
        ];
    }
}
