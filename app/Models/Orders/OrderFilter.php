<?php

namespace App\Models\Orders;

use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class OrderFilter extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'quest_ids' => 'array',
        'source_ids' => 'array',
        'statuses' => 'array',
        'promo_code_ids' => 'array',
        'with_options_only' => 'bool',
    ];
}
