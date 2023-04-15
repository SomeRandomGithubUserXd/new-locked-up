<?php

namespace App\Observers;

use App\Enums\ChangeEventEnum;
use App\Models\Orders\Order;
use App\Models\Orders\OrderChangeLogItem;
use App\Services\ChangeEventItem;

class OrderObserver
{
    public function created(Order $order): void
    {
        $this->report($order, new ChangeEventItem(ChangeEventEnum::created));
    }

    public function updated(Order $order): void
    {
        foreach ($order->getChanges() as $field => $change) {
            if ($field === 'updated_at') continue;
            $this->report($order, new ChangeEventItem(ChangeEventEnum::updated, $field, $order->getRawOriginal($field), $change));
        }
    }

    public function deleted(Order $order): void
    {
        $this->report($order, new ChangeEventItem(ChangeEventEnum::deleted));
    }

    public function restored(Order $order): void
    {
        $this->report($order, new ChangeEventItem(ChangeEventEnum::restored));
    }

    public function forceDeleted(Order $order): void
    {
        $this->report($order, new ChangeEventItem(ChangeEventEnum::forceDeleted));
    }

    protected function report(Order $order, ChangeEventItem $item): void
    {
        OrderChangeLogItem::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'change_event' => $item,
        ]);
    }
}
