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
            ...self::singleItem($this),
            'hints' => [
                'backgroundColor' => $this->status->getBackgroundColor(),
                'color' => $this->status->getColor(),
                'items' => [
                    [
                        'name' => 'Пакет',
                        'value' => $this->option
                    ],
                    [
                        'name' => 'Дополнительные игроки',
                        'value' => $this->additional_players_count
                    ],
                    [
                        'name' => 'Источник',
                        'value' => $this->source->name
                    ],
                    [
                        'name' => 'Промокод',
                        'value' => $this->promo_code ?: "-"
                    ],
                    [
                        'name' => 'Лаунж',
                        'value' => $this->lounge?->name_ru ?: "-"
                    ],
                    [
                        'name' => 'Время лаунжа',
                        'value' => $this->loungeScheduleItem?->time ?: "-"
                    ],
                ]
            ]
        ];
    }

    public static function singleItem(Order|OrderResource $order): array
    {
//        dd($order->loungeScheduleItems->toArray());
        return [
            'id' => $order->id,
            'quest_id' => $order->quest_id,
            'quest' => $order->quest->name_ru,
            'additional_players_count' => $order->additional_players_count ?? $order->quest->min_players,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'created_at' => $order->created_at->format('d/m/Y'),
            'option' => $order->option,
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
            'paid_total' => $order->paid_total,
            'price_to_pay' => $order->price_to_pay,
            'pre_paid_type' => $order->pre_paid_type,
            'postpaid_type' => $order->postpaid_type,
            'options' => $order->orderOptions->makeHidden('pivot'),
            'lounge_schedule_items' => $order->loungeScheduleItems,
            'order_option_1' => $order->order_option_1,
            'order_option_2' => $order->order_option_2,
            'order_option_3' => $order->order_option_3,
        ];
    }
}
