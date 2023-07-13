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
            'customer_phone' => $certificate->customer_phone,
            'customer_email' => $certificate->customer_email,
            'certificate_instance_id' => $certificate->number,
            'address' => $certificate->address,
            'price' => $certificate->price,
            'delivery_price' => $certificate->delivery_price,
            'payed_card' => $certificate->payed_card,
            'payed_cash' => $certificate->payed_cash,
            'payed_online' => $certificate->payed_online,
            'expires_at' => $certificate->expired,
            'payment_link' => $certificate->payment_link,
            'status' => $certificate->status,
            'comment' => $certificate->comment,
        ];
    }
}
