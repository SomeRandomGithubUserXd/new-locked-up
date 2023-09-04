<?php

namespace App\Http\Resources\Certificates;

use App\Models\Certificates\PersonCertificate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Certificates\PersonCertificate */
class PersonCertificateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'number' => $this->certificate?->number,
            'customer_address' => $this->customer_address,
            'price' => $this->price,
            'delivery_cost' => $this->delivery_cost,
            'paid_cash' => $this->paid_cash,
            'paid_card' => $this->paid_card,
            'paid_online' => $this->paid_online,
            'expires_at' => $this->expires_at?->format('Y-m-d'),
            'status' => $this->status,
            'comment' => $this->comment,
            'checkout_id' => $this->checkout_id,
            'discount' => $this->discount,
            'paid' => (int) $this->paid_online + (int) $this->paid_card + (int) $this->paid_cash
        ];
    }
}
