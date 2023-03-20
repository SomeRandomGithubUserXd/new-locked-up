<?php

namespace App\Http\Controllers;

use App\Http\Resources\ScheduleItemResource;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleItem;

class ScheduleItemController extends Controller
{
    public function index(Schedule $schedule)
    {
        $scheduleItems = ScheduleItemResource::collection(ScheduleItem::query()
            ->orderBy('time')
            ->where(['active' => 1])
            ->where(['shedule_id' => $schedule->id])
            ->where('time', '!=', '')
            ->get()
            ->unique('time'));
        return response()->json($scheduleItems);
    }
}
