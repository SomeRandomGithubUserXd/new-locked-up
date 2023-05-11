<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Orders\OrderPayment */
class OrderPaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status->getName(),
            'link' => $this->link,
            'sum' => $this->sum,
            'returned' => $this->returned,
        ];
    }
}
