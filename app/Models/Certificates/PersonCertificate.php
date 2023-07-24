<?php

namespace App\Models\Certificates;

use App\Enums\Certificates\CertificateStatusEnum;
use App\Traits\HasTimestamps;
use App\Traits\InteractsWithTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonCertificate extends Model
{
    use InteractsWithTimestamps;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'price',
        'delivery_cost',
        'paid_cash',
        'paid_card',
        'paid_online',
        'expires_at',
        'status',
        'comment',
        'checkout_id',
        'certificate_id',
        'discount',
        'is_all_cost',
    ];

    protected $casts = [
        'status' => CertificateStatusEnum::class
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(
            Certificate::class,
            'number',
            'id'
        );
    }
}
