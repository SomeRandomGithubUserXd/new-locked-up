<?php

namespace App\Traits;

use App\Enums\QuestDifficultyLevelEnum;
use App\Http\Resources\Quests\NewsListResource;
use App\Models\Checkout;
use App\Models\Locations\Location;
use App\Models\News\News;
use App\Models\Quests\Quest;
use App\Models\Quests\QuestBlock;
use App\Models\Quests\QuestChildTopic;
use App\Models\Quests\QuestLoad;
use App\Models\Quests\QuestTopic;
use App\Models\Schedules\Schedule;
use App\Models\Sticker;

trait InteractsWithQuests
{
    public function getQuestMisc(): array
    {
        return [
            'questList' => Quest::orderBy('name_ru')->where('name_ru', '!=', '')->get(),
            'questBlocks' => QuestBlock::all(),
            'newsList' => NewsListResource::collection(News::orderBy('title_ru')->get()),
            'checkouts' => Checkout::orderBy('name')->get(),
            'schedules' => Schedule::orderBy('name')->get(),
            'locations' => Location::orderBy('name_ru')->get(),
            'difficultyLevels' => QuestDifficultyLevelEnum::getArray(),
            'questTopics' => QuestTopic::orderBy('name_ru')->get(),
            'questChildTopics' => QuestChildTopic::all(),
            'loadList' => QuestLoad::all(),
            'stickerList' => Sticker::all(),
        ];
    }
}
