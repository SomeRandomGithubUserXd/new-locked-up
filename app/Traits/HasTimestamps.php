<?php

namespace App\Traits;

use App\Models\Schedules\Schedule;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasTimestamps
{
    use InteractsWithTimestamps;

    public function updatedAt(): Attribute
    {
        return $this->getTimeMutator();
    }

    public function createdAt(): Attribute
    {
        return $this->getTimeMutator();
    }
}
