<?php

namespace App\Http\Resources;

use App\Models\Schedules\ScheduleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ScheduleItem */
class ScheduleItemBookingInstanceResource extends BookingQuestResource
{
    public function toArray(Request $request): array
    {
        $isBooked = \DB::table('booked_date_schedule_item')
            ->where(['schedule_item_id' => $this->id, 'date' => self::$date->format('Y-m-d')])
            ->exists();
        return [
            'id' => $this->id,
            'time' => $this->time,
            'price' => $this->price,
            'active' => !$isBooked,
            'type' => $this->type,
        ];
    }
}
