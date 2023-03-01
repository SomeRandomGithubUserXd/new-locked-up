<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quests\GetQuestScheduleRequest;
use App\Models\Orders\Order;
use App\Models\Quest;
use App\Traits\InteractsWithOrders;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class QuestController extends Controller
{
    use InteractsWithOrders;

    public function getQuestMeta(Quest $quest, GetQuestScheduleRequest $request): JsonResponse
    {
        $type = $this->getScheduleType(Carbon::parse($request->get('date')));
//        ->where(['type' => $type])
        if ($request->get('date')) {
            $schedule = $quest
                ->scheduleItems()
                ->where('time', '!=', '')
                ->pluck('time')
                ->unique();
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
