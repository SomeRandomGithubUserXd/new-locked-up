<?php

namespace App\Traits;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait InteractsWithTimestamps
{
    public function getTimeMutator(): Attribute
    {
        return Attribute::make(
            get: static function (string $value) {
                try {
                    return Carbon::parse($value);
                } catch (InvalidFormatException) {
                    return Carbon::parse((int)$value);
                }
            },
            set: static fn(string $value) => strtotime($value),
        );
    }
}
