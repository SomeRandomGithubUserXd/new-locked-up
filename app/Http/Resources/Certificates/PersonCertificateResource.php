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
            'address' => $this->address,
            'price' => $this->price,
            'delivery_price' => $this->delivery_price,
            'payed_cash' => $this->payed_cash,
            'payed_card' => $this->payed_card,
            'payed_online' => $this->payed_online,
            'expired' => $this->expired?->format('Y-m-d'),
            'payment_link' => $this->payment_link,
            'status' => $this->status,
            'comment' => $this->comment,
            'breadcrums_point_name' => $this->breadcrums_point_name,
            'checkout_type_id' => $this->checkout_type_id,
            'discount' => $this->discount,
            'discount_value' => $this->discount_value,
        ];
    }

    public function singleItem(PersonCertificate $certificate): array
    {
        return [
            'id' => $certificate->id,
            'customer_name' => $certificate->customer_name,
            'customer_email' => $certificate->customer_email,
            'customer_phone' => $certificate->customer_phone,
            'number' => $certificate->certificate?->number,
            'address' => $certificate->address,
            'price' => $certificate->price,
            'delivery_price' => $certificate->delivery_price,
            'payed_cash' => $certificate->payed_cash,
            'payed_card' => $certificate->payed_card,
            'payed_online' => $certificate->payed_online,
            'expired' => $certificate->expired?->format('Y-m-d'),
            'payment_link' => $certificate->payment_link,
            'status' => $certificate->status,
            'comment' => $certificate->comment,
            'breadcrums_point_name' => $certificate->breadcrums_point_name,
            'checkout_type_id' => $certificate->checkout_type_id,
            'discount' => $certificate->discount,
            'discount_value' => $certificate->discount_value,
        ];
    }
}
