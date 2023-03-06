<?php

namespace App\Http\Resources;

use App\Models\Quest;
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
        return [
            'id' => $this->id,
            'name' => $this->name_ru,
            'items' => ScheduleItemBookingInstanceResource::collection(
                $this->schedule->scheduleItems,
                self::$date
            )
        ];
    }
}
