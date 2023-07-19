<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderSource extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'is_aggregator', 'is_service', 'color', 'fee',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'order_source_id');
    }
}
