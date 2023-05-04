<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quests\QuestPerformanceShowRequest;
use App\Models\Quests\Quest;
use App\Models\Quests\QuestPerformanceShow;
use Inertia\Inertia;

class QuestPerformanceShowController extends Controller
{
    public function create(Quest $quest)
    {
        return inertia('Quests/PerformanceShows/Create', [
           'questId' => $quest->id
        ]);
    }

    public function show(Quest $quest, QuestPerformanceShow $questPerformanceShow)
    {
        return inertia('Quests/PerformanceShows/Show', [
           'questId' => $quest->id,
           'questPerformanceShow' => $questPerformanceShow,
        ]);
    }

    public function store(Quest $quest, QuestPerformanceShowRequest $request)
    {
        $quest->questPerformanceShows()->create($request->validated());
        return redirect()->route('quests.show', $quest->id);
    }

    public function update(Quest $quest, QuestPerformanceShowRequest $request, QuestPerformanceShow $questPerformanceShow)
    {
        $questPerformanceShow->update($request->validated());
        return redirect()->route('quests.show', $quest->id);
    }

    public function destroy(Quest $quest, QuestPerformanceShow $questPerformanceShow)
    {
        $questPerformanceShow->delete();
        return Inertia::location(route('quests.show', $quest->id));
    }
}
