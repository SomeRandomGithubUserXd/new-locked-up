<?php

namespace App\Http\Resources\Schedules;

use App\Http\Resources\BookingQuestResource;
use App\Http\Resources\Quests\QuestResource;
use App\Models\Quests\Quest;
use App\Models\Schedules\ScheduleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ScheduleItem */
class ScheduleItemBookingInstanceResource extends JsonResource
{
    protected static ?Carbon $date = null;

    protected static int|null $questId = null;

    public static function collection($resource, Carbon $date = null, int|null $questId = null): AnonymousResourceCollection
    {
        dd($questId);
        self::$date = $date;
        self::$questId = $questId;
        return parent::collection($resource);
    }


    public function toArray(Request $request): array
    {
        dd(self::$questId);
        $isBooked = \DB::table('booked_date_schedule_item')
            ->where(['schedule_item_id' => $this->id, 'date' => self::$date->format('Y-m-d'), 'quest_id' => self::$quest->id])
            ->exists();
        if ((new Carbon(self::$date->format('Y-m-d') . ' ' . $this->time))->lessThan(now())) {
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
