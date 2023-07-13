<?php

namespace App\Http\Resources\Orders;

use App\Models\Certificates\Certificate;
use App\Models\Orders\Order;
use App\Models\Sales\Sale;
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
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'date' => str_replace(' ', "<br/>", $this->date?->format('d/m/Y H:i')),
            'source' => $this->source()?->first()?->name,
            'status' => $this->status,
            'comment' => $this->comment,
            'fact_payment' => $this->fact_payment,
            'pre_payed' => $this->prepayed,
            'online_payment' => $this->payed_online,
            'payed_aggregator' => $this->payed_aggregator,
            'price_total' => $this->price_total,
            'certificate_data_id' => $this->certificate_data_id,
        ];
    }

    public static function singleItem(Order $order): array
    {
        return [
            'id' => $order->id,
            'quest_id' => $order->quest_id,
            'players_count' => $order->countPlayers ?? $order->quest->min_players,
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
            'fact_payment' => $order->fact_payment ?? 0,
            'pre_payed' => $order->prepayed ?? 0,
            'online_payment' => $order->payed_online ?? 0,
            'payed_aggregator' => $order->payed_aggregator ?? 0,
            'status' => $order->status ?? 0,
            'price_total' => $order->price_total,
            'option' => $order->package ?? Order::$packageOptions[0],
            'fact_payment_type' => $order->fact_payment_type ?? '',
            'pre_payed_type' => $order->prepayed_type ?? '',
            'options' => $order->orderOptions->makeHidden('pivot'),
            'additional_players' => $order->additional_players,
            'lounge_schedule_item_id' => $order->lounge_schedule_item_id,
            'lounge_schedule_id' => $order->loungeScheduleItem?->loungeSchedule?->id,
            'lounge_id' => $order->lounge_id
        ];
    }
}
