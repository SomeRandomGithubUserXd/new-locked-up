<?php

namespace App\Http\Resources\Certificates;

use App\Models\Certificates\Certificate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Certificates\Certificate */
class CertificateInstanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'price' => $this->price,
            'status' => $this->status->toArray(),
        ];
    }

    public static function singleItem(Certificate $certificate): array
    {
        return [
            'id' => $certificate->id,
            'number' => $certificate->number,
            'price' => $certificate->price,
            'status' => $certificate->status->value,
        ];
    }
}
