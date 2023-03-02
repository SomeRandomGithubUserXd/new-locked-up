<?php

namespace App\Traits;

use App\Enums\OrderStatusEnum;
use App\Models\Certificate;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOption;
use App\Models\Orders\OrderSource;
use App\Models\Quest;
use App\Models\Sale;
use App\Models\Schedules\Schedule;
use Carbon\Carbon;
use Carbon\CarbonInterface;

trait InteractsWithOrders
{
    public function getScheduleType(Carbon $date): string
    {
        $type = Schedule::$weekdaysScheduleType;
        if ($date->dayOfWeek === CarbonInterface::FRIDAY) {
            $type = Schedule::$fridayScheduleType;
        }
        if ($date->isWeekend()) {
            $type = Schedule::$weekendScheduleType;
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
            'sourceList' => OrderSource::where(['isDeleted' => 0])->orderBy('name')->get(),
            'promoCodeList' => Sale::where(['is_deleted' => 0])->orderBy('promocode')->get(),
            'certificateList' => Certificate::where('status', '=', 1)->orderBy('number')->get(),
            'questOptions' => OrderOption::orderBy('name_ru')->get()->unique()
        ];
    }
}
