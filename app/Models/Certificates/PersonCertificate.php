<?php

namespace App\Models\Certificates;

use App\Enums\Certificates\CertificateStatusEnum;
use App\Models\Certificate;
use App\Traits\HasTimestamps;
use App\Traits\InteractsWithTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PersonCertificate extends Model
{
    use HasTimestamps, InteractsWithTimestamps;

    protected $guarded = ['id'];

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'number',
        'address',
        'price',
        'delivery_price',
        'payed_card',
        'payed_cash',
        'payed_online',
        'expired',
        'payment_link',
        'status',
        'comment',
    ];

    protected $table = 'certificates';

    protected $casts = [
        'status' => CertificateStatusEnum::class
    ];

    public function certificate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Certificate::class, 'number', 'id');
    }

    public function expired(): Attribute
    {
        return $this->getTimeMutator();
    }
}
