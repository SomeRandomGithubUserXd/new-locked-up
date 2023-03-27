<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Quests\ChildQuestTopicRequest;
use App\Http\Resources\Quests\QuestTopicResource;
use App\Models\Quests\ChildQuestTopic;
use Illuminate\Http\RedirectResponse;

class ChildQuestTopicController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('ChildQuestTopics/Index', [
            'questTopics' => QuestTopicResource::collection(ChildQuestTopic::paginate(15))
        ]);
    }

    public function create()
    {
        return inertia('ChildQuestTopics/Create');
    }

    public function store(ChildQuestTopicRequest $request)
    {
        ChildQuestTopic::create($request->validated());
        return redirect()->route('child-quest-topics.index');
    }

    public function show(ChildQuestTopic $childQuestTopic)
    {
        return inertia('ChildQuestTopics/Show', [
            'questTopic' => QuestTopicResource::singleChildItem($childQuestTopic)
        ]);
    }

    public function update(ChildQuestTopic $childQuestTopic, ChildQuestTopicRequest $request)
    {
        $childQuestTopic->update($request->validated());
        return redirect()->route('child-quest-topics.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        ChildQuestTopic::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
