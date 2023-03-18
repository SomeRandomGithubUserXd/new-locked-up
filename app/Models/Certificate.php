<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificates_data';

    protected $fillable = [
        "number",
        "price",
        "status",
    ];

    public $timestamps = false;
}
