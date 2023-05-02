<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\Controller;
use App\Http\Resources\Quests\QuestResource;
use App\Models\Quests\Quest;

class PerformanceQuestController extends QuestController
{
    public function index()
    {
        return inertia('Quests/Index', [
            'quests' => QuestResource::collection(
                Quest::where(['performance' => 1])->paginate(15)
            ),
        ]);
    }
}
