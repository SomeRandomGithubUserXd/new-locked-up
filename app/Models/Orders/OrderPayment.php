<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = ['order_id', 'status', 'link', 'sum', 'returned'];
}
