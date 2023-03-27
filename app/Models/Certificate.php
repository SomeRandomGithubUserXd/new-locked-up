<?php

namespace App\Models;

use App\Enums\Certificates\CertificateInstanceStatusEnum;
use Illuminate\Database\Eloquent\Model;

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
}
