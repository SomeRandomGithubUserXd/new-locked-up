<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bookings\BookingRequest;
use App\Http\Requests\Bookings\FilterRequest;
use App\Http\Resources\BookingQuestResource;
use App\Models\Quest;
use App\Models\Schedules\Schedule;
use App\Traits\InteractsWithOrders;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookingController extends Controller
{
    use InteractsWithOrders;

    public function index(FilterRequest $request)
    {
        $typeCondition = function (HasMany|Builder $query) use ($request) {
            return $query->where(['type' => $this->getScheduleType(new Carbon($request->date))]);
        };
        $quests = Quest::query()
            ->where('name_ru', '!=', '')
            ->orderBy('name_ru')
            ->whereHas('schedule.scheduleItems', $typeCondition)
            ->with('schedule.scheduleItems', $typeCondition)
            ->paginate(10);
        return inertia('Bookings/Index', [
            'quests' => BookingQuestResource::collection($quests, new Carbon($request->get('date')))
        ]);
    }

    public function make(BookingRequest $request, int $scheduleId)
    {
        \DB::table('booked_date_schedule_item')->insert([
            'date' => $request->get('date'),
            'schedule_item_id' => $scheduleId
        ]);
        return redirect()->back();
    }

    public function undo(BookingRequest $request, int $scheduleId)
    {
        \DB::table('booked_date_schedule_item')->where([
            'date' => $request->get('date'),
            'schedule_item_id' => $scheduleId
        ])->delete();
        return redirect()->back();
    }
}
