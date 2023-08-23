<?php

namespace App\Enums\Orders;

use App\Enums\ISerializableEnum;
use App\Traits\IsSerializableEnum;

enum OrderStatusEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case not_viewed = 0;

    case to_call_1 = 1;

    case to_call_2 = 2;

    case rescheduled = 3;

    case canceled = 4;

    case deleted = 5;

    case done = 6;

    case in_progress = 7;


    public function getName(): string
    {
        return match ($this) {
            self::not_viewed => 'Не обработан',
            self::to_call_1 => 'Прозвон 1',
            self::to_call_2 => 'Прозвон 2',
            self::rescheduled => 'Перенос',
            self::canceled => 'Отменен',
            self::deleted => 'Удален',
            self::done => 'Проведен',
            self::in_progress => 'В работе',
        };
    }

    public function getBackgroundColor(): string
    {
        return match ($this) {
            self::not_viewed => 'rgba(234, 51, 35, 1)',
            self::to_call_1 => 'rgba(255, 222, 136, 1)',
            self::rescheduled => 'rgba(0, 135, 156, 1)',
            self::to_call_2 => 'rgba(220, 220, 114, 1)',
            self::done => 'rgba(76, 161, 84, 1)',
            self::canceled => 'rgba(255, 136, 125, 1)',
            self::deleted => 'rgba(148, 148, 148, 1)',
            self::in_progress => 'rgba(252, 184, 10, 1)',
        };
    }

    //TODO: reassign colors
    public function getColor(): string
    {
        return match ($this) {
            self::not_viewed, self::deleted, self::done, self::rescheduled => 'rgba(255, 255, 255, 1)',
            self::to_call_1, self::to_call_2, self::canceled, self::in_progress => 'rgba(0, 0, 0, 1)',
        };
    }

    public function toArray(): array
    {
        return [
            'key' => $this->value,
            'name' => $this->getName(),
            'color' => $this->getColor(),
            'backgroundColor' => $this->getBackgroundColor(),
        ];
    }
}
