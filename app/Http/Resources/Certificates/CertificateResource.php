<?php

namespace App\Http\Resources\Certificates;

use App\Models\Certificates\PersonCertificate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Certificates\Certificate */
class CertificateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'price' => $this->price,
            'status' => $this->status,
        ];
    }

    public static function singleItem(PersonCertificate $certificate): array
    {
        return [
            'id' => $certificate->id,
            'customer_name' => $certificate->customer_name,
            'customer_email' => $certificate->customer_email,
            'customer_phone' => $certificate->customer_phone,
            'certificate_id' => $certificate->certificate_id,
            'customer_address' => $certificate->customer_address,
            'price' => $certificate->price,
            'delivery_cost' => $certificate->delivery_cost,
            'paid_cash' => $certificate->paid_cash,
            'paid_card' => $certificate->paid_card,
            'paid_online' => $certificate->paid_online,
            'expires_at' => $certificate->expires_at?->format('Y-m-d'),
            'status' => $certificate->status,
            'comment' => $certificate->comment,
            'checkout_id' => $certificate->checkout_id,
            'discount' => $certificate->discount,
        ];
    }
}
