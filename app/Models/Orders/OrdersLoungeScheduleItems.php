<?php

namespace App\Models\Orders;

use App\Models\Lounges\Lounge;
use App\Models\Lounges\LoungeScheduleItem;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrdersLoungeScheduleItems extends Pivot
{
    protected $table = 'orders_lounge_schedule_items';

    protected $appends = ['lounge_instance'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function lounge(): BelongsTo
    {
        return $this->belongsTo(Lounge::class);
    }

    public function getLoungeInstanceAttribute(): Lounge
    {
        return $this->lounge;
    }

    public function loungeScheduleItem(): BelongsTo
    {
        return $this->belongsTo(LoungeScheduleItem::class);
    }
}
