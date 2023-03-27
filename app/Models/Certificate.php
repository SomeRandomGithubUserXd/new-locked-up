<?php

namespace App\Models;

use App\Enums\CertificateInstanceEnum;
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
        'status' => CertificateInstanceEnum::class
    ];

    public $timestamps = false;
}
