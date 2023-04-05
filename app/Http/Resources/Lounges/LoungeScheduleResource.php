<?php

namespace App\Http\Resources\Lounges;

use App\Models\Lounges\LoungeSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Lounges\LoungeSchedule */
class LoungeScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public static function singleItem(LoungeSchedule $schedule): array
    {
        return [
            'id' => $schedule->id,
            'name' => $schedule->name,
            'schedule_items' => $schedule->loungeScheduleItems
        ];
    }
}
