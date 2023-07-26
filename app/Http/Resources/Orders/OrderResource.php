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
            'fact_payment' => $this->postpaid,
            'pre_payed' => $this->pre_paid,
            'online_payment' => $this->paid_through_acquiring,
            'payed_aggregator' => $this->paid_through_aggregator,
            'price_total' => $this->price_total,
            'certificate_data_id' => $this->certificate_id,
        ];
    }

    public static function singleItem(Order $order): array
    {
        return [
            'id' => $order->id,
            'quest_id' => $order->quest_id,
            'additional_players_count' => $order->additional_players_count ?? $order->quest->min_players,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'created_at' => $order->created_at->format('d/m/Y'),
            'date' => $order->date->format('Y-m-d'),
            'time' => $order->time,
            'order_source_id' => $order->order_source_id,
            'promo_code' => $order->promo_code,
            'certificate_id' => $order->certificate_id,
            'comment' => $order->comment,
            'postpaid' => $order->postpaid ?? 0,
            'pre_paid' => $order->pre_paid ?? 0,
            'paid_through_acquiring' => $order->paid_through_acquiring ?? 0,
            'paid_through_aggregator' => $order->paid_through_aggregator ?? 0,
            'status' => $order->status ?? 0,
            'price_total' => $order->price_total,
            'option' => $order->package ?? Order::$packageOptions[0],
            'postpaid_type' => $order->postpaid_type ?? '',
            'pre_paid_type' => $order->pre_paid_type ?? '',
            'options' => $order->orderOptions->makeHidden('pivot'),
            'additional_players' => 0,
            'lounge_schedule_item_id' => $order->lounge_schedule_item_id,
            'lounge_schedule_id' => $order->loungeScheduleItem?->loungeSchedule?->id,
            'lounge_id' => $order->lounge_id
        ];
    }
}
