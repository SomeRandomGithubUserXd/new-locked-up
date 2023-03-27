<?php

namespace App\Traits;

use App\Enums\Certificates\CertificateInstanceTypeEnum;
use App\Http\Resources\Quests\NewsListResource;
use App\Models\Checkout;
use App\Models\News\News;
use App\Models\Quests\Quest;
use App\Models\Quests\QuestBlock;
use App\Models\Schedules\Schedule;

trait InteractsWithSales
{
    /**
     * @throws \ReflectionException
     */
    public function getSalesMisc(): array
    {
        return [
            'certificateTypes' => CertificateInstanceTypeEnum::getArray(),
            'questList' => Quest::query()
                ->select(['id', 'name_ru'])
                ->where('name_ru', '!=', '')
                ->orderBy('name_ru')
                ->get(),
        ];
    }
}
