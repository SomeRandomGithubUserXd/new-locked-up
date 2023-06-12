<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderSource extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'aggregator', 'color', 'is_service', 'fee'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'source');
    }
}
