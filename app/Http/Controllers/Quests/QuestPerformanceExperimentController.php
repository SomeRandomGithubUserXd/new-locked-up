<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quests\QuestPerformanceExperimentRequest;
use App\Models\Quests\Quest;
use App\Models\Quests\QuestPerformanceExperiment;
use Inertia\Inertia;

class QuestPerformanceExperimentController extends Controller
{
    public function create(Quest $quest)
    {
        return inertia('Quests/PerformanceExperiments/Create', [
            'questId' => $quest->id
        ]);
    }

    public function show(Quest $quest, QuestPerformanceExperiment $questPerformanceExperiment)
    {
        return inertia('Quests/PerformanceExperiments/Show', [
            'questId' => $quest->id,
            'questPerformanceExperiment' => $questPerformanceExperiment,
        ]);
    }

    public function store(Quest $quest, QuestPerformanceExperimentRequest $request)
    {
        $quest->questPerformanceExperiments()->create($request->validated());
        return redirect()->route('quests.show', $quest->id);
    }

    public function update(Quest $quest, QuestPerformanceExperimentRequest $request, QuestPerformanceExperiment $questPerformanceExperiment)
    {
        $questPerformanceExperiment->update($request->validated());
        return redirect()->route('quests.show', $quest->id);
    }

    public function destroy(Quest $quest, QuestPerformanceExperiment $questPerformanceExperiment)
    {
        $questPerformanceExperiment->delete();
        return Inertia::location(route('quests.show', $quest->id));
    }
}
