<?php

namespace App\Models\Orders;

use App\Models\Orders\OrderSource;
use App\Models\Quest;
use App\Traits\InteractsWithTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use InteractsWithTimestamps;

    public static array $statuses = [
        0 => [
            "name" => "не отработан",
            "color" => "red",
        ],
        1 => [
            "name" => "прозвон 1",
            "color" => "rgb(220,220,95)",
        ],
        2 => [
            "name" => "прозвон 2",
            "color" => "green",
        ],
        3 => [
            "name" => "перенос",
            "color" => "rgb(220,220,95)",
        ],
        4 => [
            "name" => "отменен",
            "color" => "orange",
        ],
        5 => [
            "name" => "удален",
            "color" => "orange",
        ],
        6 => [
            "name" => "проведен",
            "color" => "green",
        ],
    ];

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

    public function date(): Attribute
    {
        return $this->getTimeMutator();
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }

    public function sources(): BelongsTo
    {
        return $this->belongsTo(OrderSource::class, 'source', 'id');
    }
}
