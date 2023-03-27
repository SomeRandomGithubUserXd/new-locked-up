<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Quests\QuestTopicRequest;
use App\Http\Resources\Quests\QuestTopicResource;
use App\Models\Quests\QuestTopic;
use Illuminate\Http\RedirectResponse;

class QuestTopicController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('QuestTopics/Index', [
            'questTopics' => QuestTopicResource::collection(QuestTopic::paginate(15))
        ]);
    }

    public function show(QuestTopic $questTopic)
    {
        return inertia('QuestTopics/Show', [
            'questTopic' => QuestTopicResource::singleItem($questTopic)
        ]);
    }

    public function create()
    {
        return inertia('QuestTopics/Create');
    }

    public function store(QuestTopicRequest $questTopicRequest)
    {
        QuestTopic::create($questTopicRequest->validated());
        return redirect()->route('quest-topics.index');
    }

    public function update(QuestTopic $questTopic, QuestTopicRequest $questTopicRequest)
    {
        $questTopic->update($questTopicRequest->validated());
        return redirect()->route('quest-topics.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
//        QuestTopic::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
