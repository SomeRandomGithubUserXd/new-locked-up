<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Schedules\ScheduleRequest;
use App\Http\Resources\Schedules\ScheduleResource;
use App\Models\Schedules\Schedule;
use App\Models\Schedules\ScheduleItem;
use Illuminate\Http\RedirectResponse;

class ScheduleController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        $schedules = Schedule::query()
            ->paginate(15);
        return inertia('Schedules/Index', [
            'schedules' => ScheduleResource::collection($schedules)
        ]);
    }

    public function create()
    {
        return inertia('Schedules/Create');
    }

    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update(['name' => $request->get('name')]);
        foreach ($request->get('schedule_items') as $item) {
            ScheduleItem::find($item['id'])->update($item);
        }
        return redirect()->route('schedules.index');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load('scheduleItems');
        return inertia('Schedules/Show', [
            'schedule' => ScheduleResource::singleItem($schedule)
        ]);
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Schedule::whereIn('id', $request->ids)->delete();
        return redirect()->back();
    }
}
