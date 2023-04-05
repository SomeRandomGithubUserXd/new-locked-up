<?php

namespace App\Http\Resources\Lounges;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Lounges\LoungeScheduleItem */
class LoungeScheduleItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'time' => $this->time,
            'price' => $this->price,
            'type' => $this->type,
            'lounge_schedule_id' => $this->lounge_schedule_id,
        ];
    }
}
