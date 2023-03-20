<?php

namespace App\Traits;

use App\Enums\OrderStatusEnum;
use App\Http\Resources\Quests\NewsListResource;
use App\Models\Certificate;
use App\Models\Checkout;
use App\Models\News\News;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOption;
use App\Models\Orders\OrderSource;
use App\Models\Quests\Quest;
use App\Models\Quests\QuestBlock;
use App\Models\Sale;
use App\Models\Schedules\Schedule;
use Carbon\Carbon;
use Carbon\CarbonInterface;

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
        ];
    }
}
