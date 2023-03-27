<?php

namespace App\Http\Resources\Schedules;

use App\Models\Schedules\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Schedules\Schedule */
class ScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quest' => $this->quest?->name_ru,
        ];
    }

    public static function singleItem(Schedule $schedule): array
    {
        return [
            'id' => $schedule->id,
            'name' => $schedule->name,
            'schedule_items' => $schedule->scheduleItems,
        ];
    }
}
