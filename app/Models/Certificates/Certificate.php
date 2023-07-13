<?php

namespace App\Models\Certificates;

use App\Enums\Certificates\CertificateInstanceStatusEnum;
use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Certificate extends Model
{
    protected $fillable = [
        "number",
        "price",
        "status",
    ];

    protected $casts = [
        'status' => CertificateInstanceStatusEnum::class
    ];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'certificate_data_id');
    }
}
