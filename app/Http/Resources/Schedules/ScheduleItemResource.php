<?php

namespace App\Http\Resources\Schedules;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Schedules\ScheduleItem */
class ScheduleItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'time' => $this->time,
            'price' => $this->price,
            'active' => $this->active,
            'type' => $this->type,

            'schedule_id' => $this->schedule_id,
        ];
    }
}
