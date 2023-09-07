<?php

namespace App\Http\Resources;

use App\Http\Resources\Quests\QuestResource;
use App\Http\Resources\Schedules\ScheduleItemBookingInstanceResource;
use App\Models\Quests\Quest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Quest */
class BookingQuestResource extends JsonResource
{
    protected static ?Carbon $date = null;

    public static function collection($resource, Carbon $date = null): AnonymousResourceCollection
    {
        self::$date = $date;
        return parent::collection($resource);
    }

    public function toArray(Request $request): array
    {
//        dd($this->id);
        $items = [];
        foreach ($this->schedule->scheduleItems as $scheduleItem) {
            $isBooked = \DB::table('booked_date_schedule_item')
                ->where(['schedule_item_id' => $scheduleItem->id, 'date' => self::$date->format('Y-m-d'), 'quest_id' => $this->id])
                ->exists();
            if ((new Carbon(self::$date->format('Y-m-d') . ' ' . $scheduleItem->time))->lessThan(now())) {
                $isBooked = true;
            }
            $items[] = [
                'id' => $scheduleItem->id,
                'time' => $scheduleItem->time,
                'price' => $scheduleItem->price,
                'active' => !$isBooked,
                'type' => $scheduleItem->type,
            ];
        }
        return [
            'id' => $this->id,
            'name' => $this->name_ru,
            'items' => $items
        ];
    }
}
