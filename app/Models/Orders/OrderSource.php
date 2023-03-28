<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderSource extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'aggregator', 'color', 'is_service', 'fee'];
}
