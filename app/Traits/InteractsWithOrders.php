<?php

namespace App\Traits;

use App\Enums\OrderStatusEnum;
use App\Enums\ScheduleTypeEnum;
use App\Models\Certificates\Certificate;
use App\Models\Lounges\Lounge;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOption;
use App\Models\Orders\OrderSource;
use App\Models\Quests\Quest;
use App\Models\Sales\Sale;
use Carbon\Carbon;
use Carbon\CarbonInterface;

trait InteractsWithOrders
{
    public function getScheduleType(Carbon $date): ScheduleTypeEnum
    {
        $type = ScheduleTypeEnum::weekdays;
        if ($date->dayOfWeek === CarbonInterface::FRIDAY) {
            $type = ScheduleTypeEnum::friday;
        }
        if ($date->isWeekend()) {
            $type = ScheduleTypeEnum::weekend;
        }
        return $type;
    }

    public function getOrderMisc(): array
    {
        return [
            'orderStatuses' => OrderStatusEnum::getArray(),
            'questList' => Quest::query()
                ->where('name_ru', '!=', '')
                ->select(['id', 'name_ru'])
                ->orderBy('name_ru')
                ->get(),
            'optionList' => Order::$packageOptions,
            'sourceList' => OrderSource::orderBy('name')->get(),
            'promoCodeList' => Sale::orderBy('promo_code')->get(),
            'certificateList' => Certificate::where('status', '=', 1)->orderBy('number')->get(),
            'questOptions' => OrderOption::orderBy('name_ru')->get()->unique(),
            'loungeList' => Lounge::with('loungeSchedule.loungeScheduleItems')->get()
        ];
    }
}
