<?php

namespace App\Models\Certificates;

use App\Models\Certificate;
use App\Traits\HasTimestamps;
use App\Traits\InteractsWithTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PersonCertificate extends Model
{
    use HasTimestamps, InteractsWithTimestamps;

    protected $table = 'certificates';

    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'number', 'id');
    }

    public function expired(): Attribute
    {
        return $this->getTimeMutator();
    }
}
