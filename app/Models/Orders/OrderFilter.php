<?php

namespace App\Models\Orders;

use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class OrderFilter extends Model
{
    protected $fillable = [
        'name',
        'date_from',
        'date_to',
        'quest_ids',
        'order_id',
        'source_ids',
        'statuses',
        'promo_code_ids',
        'with_options_only',
        'order_by'
    ];

    protected $casts = [
        'quest_ids' => 'array',
        'source_ids' => 'array',
        'statuses' => 'array',
        'promo_code_ids' => 'array',
        'with_options_only' => 'bool',
    ];
}
