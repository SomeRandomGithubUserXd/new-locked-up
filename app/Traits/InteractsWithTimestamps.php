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
            get: static function (string|null $value) {
                if ($value) {
                    try {
                        return Carbon::parse($value)->setTimezone(config('app.timezone'));
                    } catch (InvalidFormatException) {
                        return Carbon::parse((int)$value)->setTimezone(config('app.timezone'));
                    }
                }
            },
            set: static fn(string $value) => strtotime($value),
        );
    }
}
