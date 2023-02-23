<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait InteractsWithTimestamps
{
    public function getTimeMutator(): Attribute
    {
        return Attribute::make(
            get: static fn (string $value) => Carbon::createFromTimestamp($value),
            set: static fn (string $value) => strtotime($value),
        );
    }
}
