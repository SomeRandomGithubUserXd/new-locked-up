<?php

namespace App\Traits;

use App\Enums\QuestDifficultyLevelEnum;
use App\Http\Resources\Quests\NewsListResource;
use App\Models\Checkout;
use App\Models\Location;
use App\Models\News\News;
use App\Models\Quests\Quest;
use App\Models\Quests\QuestBlock;
use App\Models\Quests\QuestTopic;
use App\Models\Schedules\Schedule;

trait InteractsWithQuests
{
    public function getQuestMisc(): array
    {
        return [
            'questList' => Quest::where('name_ru', '!=', '')->get(),
            'questBlocks' => QuestBlock::get(),
            'newsList' => NewsListResource::collection(News::get()),
            'checkouts' => Checkout::get(),
            'schedules' => Schedule::get(),
            'locations' => Location::get(),
            'difficultyLevels' => QuestDifficultyLevelEnum::getArray(),
            'questTopics' => QuestTopic::get()
        ];
    }
}
