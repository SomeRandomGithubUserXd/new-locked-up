<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\ScheduleItemResource;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleItem;
use Illuminate\Http\Request;

class ScheduleItemController extends Controller
{
    public function index(Schedule $schedule)
    {
        $scheduleItems = ScheduleItemResource::collection(ScheduleItem::query()
            ->orderBy('time')
            ->where(['active' => 1])
            ->where(['schedule_id' => $schedule->id])
            ->where('time', '!=', '')
            ->get()
            ->unique('time'));
        return response()->json($scheduleItems);
    }

    public function store(Schedule $schedule, Request $request)
    {
        $schedule->scheduleItems()->create(['type' => $request->type]);
        return redirect()->back();
    }

    public function destroy($id)
    {
        ScheduleItem::find($id)->delete();
        return redirect()->back();
    }
}
