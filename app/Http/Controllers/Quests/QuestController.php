<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Quests\GetQuestScheduleRequest;
use App\Http\Resources\Quests\NewsListResource;
use App\Http\Resources\Quests\QuestResource;
use App\Models\News\News;
use App\Models\News\NewsQuests;
use App\Models\Orders\Order;
use App\Models\Quests\Quest;
use App\Models\Quests\QuestBlock;
use App\Models\Schedules\ScheduleItem;
use App\Traits\InteractsWithOrders;
use App\Traits\InteractsWithQuests;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class QuestController extends AbstractControllerWithMultipleDeletion
{
    use InteractsWithQuests;

    public function index()
    {
        return inertia('Quests/Index', [
            'quests' => QuestResource::collection(Quest::orderBy('ord')->paginate(15)),
        ]);
    }

    public function create()
    {
        return inertia('Quests/Create', $this->getQuestMisc());
    }

    public function show(Quest $quest)
    {
        return inertia('Quests/Show', [
            'quest' => QuestResource::singleItem($quest),
            ...$this->getQuestMisc()
        ]);
    }

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

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        return redirect()->back();
    }
}
