<?php

namespace App\Http\Controllers\Lounges;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Schedules\ScheduleRequest;
use App\Http\Resources\Lounges\LoungeScheduleResource;
use App\Models\Lounges\Lounge;
use App\Models\Lounges\LoungeSchedule;
use App\Models\Lounges\LoungeScheduleItem;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleItem;
use Illuminate\Http\RedirectResponse;

class LoungeScheduleController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('LoungeSchedules/Index', [
            'loungeSchedules' => LoungeScheduleResource::collection(LoungeSchedule::paginate(15))
        ]);
    }

    public function show(LoungeSchedule $loungeSchedule)
    {
        return inertia('LoungeSchedules/Show', [
            'schedule' => LoungeScheduleResource::singleItem($loungeSchedule)
        ]);
    }

    public function update(ScheduleRequest $request, LoungeSchedule $loungeSchedule)
    {
        $loungeSchedule->update(['name' => $request->get('name')]);
        foreach ($request->get('schedule_items') as $item) {
            LoungeScheduleItem::find($item['id'])->update($item);
        }
        return redirect()->route('lounge-schedules.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        LoungeSchedule::whereIn('id', $request->get('ids'));
        return redirect()->back();
    }
}
