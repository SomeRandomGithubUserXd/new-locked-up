<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Quests\GetQuestScheduleRequest;
use App\Http\Requests\Quests\QuestRequest;
use App\Http\Resources\Quests\QuestResource;
use App\Models\Quests\Quest;
use App\Models\Schedules\ScheduleItem;
use App\Traits\InteractsWithOrders;
use App\Traits\InteractsWithQuests;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class QuestController extends AbstractControllerWithMultipleDeletion
{
    use InteractsWithQuests, InteractsWithOrders;

    public function index()
    {
        return inertia('Quests/Index', [
            'quests' => QuestResource::collection(Quest::paginate(15)),
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

    public function store(QuestRequest $request)
    {
        $rawData = $this->getRelationsFreeData($request->getUnRefactoredValidatedData());
        $quest = Quest::create($rawData);
        $this->refreshRelations($quest, $request);
        return redirect()->route('quests.index');
    }

    public function update(QuestRequest $request, Quest $quest)
    {
        $rawData = $this->getRelationsFreeData($request->getUnRefactoredValidatedData());
        $quest->update($rawData);
        $this->refreshRelations($quest, $request);
        return redirect()->route('quests.index');
    }

    protected function getRelationsFreeData(array $rawData)
    {
        unset(
            $rawData['related_quest_ids'],
            $rawData['advantages'],
            $rawData['options'],
            $rawData['applied_sales'],
            $rawData['you_may_like_it_section_quest_ids'],
            $rawData['quest_topic_ids'],
            $rawData['loads'],
        );
        return $rawData;
    }

    protected function refreshRelations(Quest $quest, QuestRequest $request)
    {
        $quest->relatedQuests()->sync($request->get('related_quest_ids'));
        $quest->questAdvantages()->delete();
        foreach ($request->get('advantages') as $item) {
            $quest->questAdvantages()->firstOrCreate([
                'name_ru' => $item['header'],
                'description_ru' => $item['shortDescription']
            ]);
        }
        $quest->questOptions()->delete();
        foreach ($request->get('options') as $item) {
            $quest->questOptions()->firstOrCreate([
                'name_ru' => $item['header'],
            ]);
        }
        foreach ($request->get('options') as $item) {
            $quest->questOptions()->firstOrCreate([
                'name_ru' => $item['header'],
            ]);
        }
        $quest->news()->sync($request->get('applied_sales'));
        $quest->questLoad()->sync($request->get('loads'));
        $quest->questTopics()->sync($request->get('quest_topic_ids'));
        $quest->questChildTopics()->sync($request->get('quest_child_topic_ids'));
    }

    public function getQuestMeta(Quest $quest, GetQuestScheduleRequest $request): JsonResponse
    {
        $type = $this->getScheduleType(Carbon::parse($request->get('date')))->value;
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
