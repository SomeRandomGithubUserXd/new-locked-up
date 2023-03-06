<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quests\GetQuestScheduleRequest;
use App\Models\Orders\Order;
use App\Models\Quest;
use App\Models\Schedules\ScheduleItem;
use App\Traits\InteractsWithOrders;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class QuestController extends Controller
{
    use InteractsWithOrders;

    public function getQuestMeta(Quest $quest, GetQuestScheduleRequest $request): JsonResponse
    {
        $type = $this->getScheduleType(Carbon::parse($request->get('date')));
        if ($request->get('date')) {
            $schedule = ScheduleItem::where(['shedule_id' => $quest->schedule_id])
                ->where(['type' => $type])
                ->orderBy('time')
                ->get();
        }
        return response()->json([
            'schedule' => $schedule ?? null,
            'min_players' => $quest->min_players,
            'max_players' => $quest->max_players,
            'price' => $quest->price_command,
            'price_per_participant' => $quest->price_single,
        ]);
    }
}
