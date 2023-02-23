<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // TODO: Must be refactored in the future
    protected $fillable = ['quest_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'date',
        'price',
        'price_players',
        'price_options',
        'certificate_id',
        'payed_cash',
        'payed_card',
        'payed_online',
        'source',
        'status',
        'comment',
        'promo',
        'discount_value',
        'blocking',
        'fact_payment',
        'prepayed',
        'tech_prod_id',
        'prepayed_type',
        'fact_payment_type',
        'price_total',
        'checkout_type_id',
        'payed_aggregator',
        'package',
        'countPlayers',
        'lounge_id',
        'lounge_schedule_id'
    ];
}
