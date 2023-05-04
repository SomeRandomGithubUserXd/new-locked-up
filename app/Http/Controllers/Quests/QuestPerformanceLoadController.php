<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quests\QuestPerformanceLoadRequest;
use App\Models\Quests\Quest;
use App\Models\Quests\QuestPerformanceLoad;
use Inertia\Inertia;

class QuestPerformanceLoadController extends Controller
{
    public function create(Quest $quest)
    {
        return inertia('Quests/PerformanceLoads/Create', [
            'questId' => $quest->id
        ]);
    }

    public function show(Quest $quest, QuestPerformanceLoad $questPerformanceLoad)
    {
        return inertia('Quests/PerformanceLoads/Show', [
            'questId' => $quest->id,
            'questPerformanceLoad' => $questPerformanceLoad,
        ]);
    }

    public function store(Quest $quest, QuestPerformanceLoadRequest $request)
    {
        $quest->questPerformanceLoads()->create($request->validated());
        return redirect()->route('quests.show', $quest->id);
    }

    public function update(Quest $quest, QuestPerformanceLoadRequest $request, QuestPerformanceLoad $questPerformanceLoad)
    {
        $questPerformanceLoad->update($request->validated());
        return redirect()->route('quests.show', $quest->id);
    }

    public function destroy(Quest $quest, QuestPerformanceLoad $questPerformanceLoad)
    {
        $questPerformanceLoad->delete();
        return Inertia::location(route('quests.show', $quest->id));
    }
}
