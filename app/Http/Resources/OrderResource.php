<?php

namespace App\Http\Resources;

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
            'updated_at' => $this->updated_at,
            'date' => $this->date->format('d/m/Y H:i:s'),
            'price' => $this->price,
            'price_players' => $this->price_players,
            'price_options' => $this->price_options,
            'certificate_id' => $this->certificate_id,
            'payed_cash' => $this->payed_cash,
            'payed_card' => $this->payed_card,
            'payed_online' => $this->payed_online,
            'source' => $this->source,
            'status' => $this->status,
            'comment' => $this->comment,
            'promo' => $this->promo,
            'discount_value' => $this->discount_value,
            'blocking' => $this->blocking,
            'fact_payment' => $this->fact_payment,
            'prepayed' => $this->prepayed,
            'tech_prod_id' => $this->tech_prod_id,
            'prepayed_type' => $this->prepayed_type,
            'fact_payment_type' => $this->fact_payment_type,
            'price_total' => $this->price_total,
            'vnutrennee_bronirovanie' => $this->vnutrennee_bronirovanie,
            'checkout_type_id' => $this->checkout_type_id,
            'payed_aggregator' => $this->payed_aggregator,
            'package' => $this->package,
            'countPlayers' => $this->countPlayers,
            'lounge_id' => $this->lounge_id,
            'lounge_schedule_id' => $this->lounge_schedule_id,
            'sources' => $this->sources
        ];
    }
}
