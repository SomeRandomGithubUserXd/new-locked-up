<?php

namespace App\Models;

use App\Enums\Certificates\CertificateInstanceStatusEnum;
use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Certificate extends Model
{
    protected $table = 'certificates_data';

    protected $fillable = [
        "number",
        "price",
        "status",
    ];

    protected $casts = [
        'status' => CertificateInstanceStatusEnum::class
    ];

    public $timestamps = false;

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'certificate_data_id');
    }
}
