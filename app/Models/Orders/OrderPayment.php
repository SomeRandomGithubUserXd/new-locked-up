<?php

namespace App\Models\Orders;

use App\Enums\OrderPaymentStatusEnum;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = ['order_id', 'id_from_provider', 'order_number', 'status', 'link', 'sum', 'returned'];

    public function sum(): Attribute
    {
        return Attribute::make(
            get: static fn(int $value) => $value / 100,
        );
    }

    protected $casts = [
        'status' => OrderPaymentStatusEnum::class
    ];
}
