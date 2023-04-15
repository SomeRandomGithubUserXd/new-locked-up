<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Orders\OrderChangeLogItem */
class LogsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order' => $this->order->id,
            'user' => $this->user->username,
            'string_value' => $this->change_event,
            'date' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
