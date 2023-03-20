<?php

namespace App\Http\Resources;

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

            'shedule_id' => $this->shedule_id,
        ];
    }
}
