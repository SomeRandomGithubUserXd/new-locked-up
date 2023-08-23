<?php

namespace App\Models\Orders;

use App\Enums\Orders\OrderPaymentStatusEnum;
use App\Enums\Orders\OrderPaymentTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPayment extends Model
{
    protected $fillable = ['order_id', 'id_from_provider', 'status', 'order_number', 'type', 'payment_option', 'date', 'status', 'link', 'sum', 'returned'];

    protected $appends = ['can_be_returned'];

    public function sum(): Attribute
    {
        return Attribute::make(
            get: static fn(int $value) => $value / 100,
        );
    }

    public function canBeReturned(): Attribute
    {
        return Attribute::make(
            get: fn() => (int) $this->returned === 0 && $this->status === OrderPaymentStatusEnum::paid,
        );
    }

    protected $casts = [
        'type' => OrderPaymentTypeEnum::class,
        'status' => OrderPaymentStatusEnum::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
