<?php

namespace App\Http\Resources\Schedules;

use App\Http\Resources\BookingQuestResource;
use App\Models\Schedules\ScheduleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

/** @mixin ScheduleItem */
class ScheduleItemBookingInstanceResource extends BookingQuestResource
{
    public function toArray(Request $request): array
    {
        $isBooked = \DB::table('booked_date_schedule_item')
            ->where(['schedule_item_id' => $this->id, 'date' => self::$date->format('Y-m-d')])
            ->exists();
        if ((new Carbon(self::$date->format('Y-m-d').' '.$this->time))->lessThan(now())) {
            $isBooked = true;
        }
        return [
            'id' => $this->id,
            'time' => $this->time,
            'price' => $this->price,
            'active' => !$isBooked,
            'type' => $this->type,
        ];
    }
}
