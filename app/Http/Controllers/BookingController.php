<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bookings\BookingRequest;
use App\Http\Requests\Bookings\FilterRequest;
use App\Http\Resources\BookingQuestResource;
use App\Models\Locations\Location;
use App\Models\Quests\Quest;
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
            return $query->where(['type' => $this->getScheduleType(new Carbon($request->date))->value]);
        };
        $quests = Quest::query()
            ->where('name_ru', '!=', '')
            ->when($request->get('location_id'), function (Builder $query) use ($request) {
                return $query->where(['location_id' => $request->get('location_id')]);
            })
            ->orderBy('name_ru')
            ->whereHas('schedule.scheduleItems', $typeCondition)
            ->with('schedule.scheduleItems', $typeCondition)
            ->paginate(10);
        return inertia('Bookings/Index', [
            'quests' => BookingQuestResource::collection($quests, new Carbon($request->get('date'))),
            'locations' => Location::orderBy('name_ru')->get()
        ]);
    }

    public function make(BookingRequest $request, int $scheduleId)
    {
        \DB::table('booked_date_schedule_item')->insert([
            'date' => $request->get('date'),
            'schedule_item_id' => $scheduleId,
            'order_id' => 0
        ]);
        return redirect()->back();
    }

    public function undo(BookingRequest $request, int $scheduleId)
    {
        \DB::table('booked_date_schedule_item')->where([
            'date' => $request->get('date'),
            'schedule_item_id' => $scheduleId,
            'order_id' => 0
        ])->delete();
        return redirect()->back();
    }
}
