<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quests\QuestPerformanceLoungeRequest;
use App\Models\Quests\Quest;
use App\Models\Quests\QuestPerformanceLounge;
use Inertia\Inertia;

class QuestPerformanceLoungeController extends Controller
{
    public function create(Quest $quest)
    {
        return inertia('Quests/PerformanceLounges/Create', [
            'questId' => $quest->id
        ]);
    }

    public function show(Quest $quest, QuestPerformanceLounge $questPerformanceLounge)
    {
        return inertia('Quests/PerformanceLounges/Show', [
            'questId' => $quest->id,
            'questPerformanceLounge' => $questPerformanceLounge,
        ]);
    }

    public function store(Quest $quest, QuestPerformanceLoungeRequest $request)
    {
        $quest->questPerformanceLounges()->create($request->validated());
        return redirect()->route('quests.show', $quest->id);
    }

    public function update(Quest $quest, QuestPerformanceLoungeRequest $request, QuestPerformanceLounge $questPerformanceLounge)
    {
        $questPerformanceLounge->update($request->validated());
        return redirect()->route('quests.show', $quest->id);
    }

    public function destroy(Quest $quest, QuestPerformanceLounge $questPerformanceLounge)
    {
        $questPerformanceLounge->delete();
        return Inertia::location(route('quests.show', $quest->id));
    }
}
