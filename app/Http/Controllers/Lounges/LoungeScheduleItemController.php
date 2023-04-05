<?php

namespace App\Http\Controllers\Lounges;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lounges\LoungeScheduleItemResource;
use App\Http\Resources\Schedules\ScheduleItemResource;
use App\Models\Lounges\LoungeSchedule;
use App\Models\Lounges\LoungeScheduleItem;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleItem;
use Illuminate\Http\Request;

class LoungeScheduleItemController extends Controller
{
    public function index(LoungeSchedule $loungeSchedule)
    {
        $scheduleItems = LoungeScheduleItemResource::collection(LoungeScheduleItem::query()
            ->orderBy('time')
            ->where(['active' => 1])
            ->where(['lounge_schedule_id' => $loungeSchedule->id])
            ->where('time', '!=', '')
            ->get()
            ->unique('time'));
        return response()->json($scheduleItems);
    }

    public function store(LoungeSchedule $loungeSchedule, Request $request)
    {
        $loungeSchedule->loungeScheduleItems()->create([
            'type' => $request->type,
            'time' => '00:00',
            'price' => 0
        ]);
        return redirect()->back();
    }

    public function destroy($id)
    {
        LoungeScheduleItem::find($id)->delete();
        return redirect()->back();
    }
}
