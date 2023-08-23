<?php

namespace App\Enums\Orders;

use App\Enums\ISerializableEnum;
use App\Traits\IsSerializableEnum;

enum OrderPaymentTypeEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;
    case pre_payment = 0;

    case post_payment = 1;

    case paid_through_acquiring = 2;

    case paid_through_aggregator = 3;

    public function getName(): string
    {
        return match ($this) {
            self::pre_payment => 'Предоплата',
            self::post_payment => 'Факт',
            self::paid_through_acquiring => 'Онлайн оплата',
            self::paid_through_aggregator => 'Агрегатор',
        };
    }

    public function getBackgroundColor(): string
    {
        return match ($this) {
            self::pre_payment => 'rgba(209, 38, 124, 1)',
            self::post_payment => 'rgba(203, 128, 239, 1)',
            self::paid_through_acquiring => 'rgba(117, 68, 156, 1)',
            self::paid_through_aggregator => 'rgba(219, 161, 190, 1)',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::paid_through_aggregator => 'rgba(0, 0, 0, 1)',
            self::pre_payment, self::post_payment, self::paid_through_acquiring => 'rgba(255, 255, 255, 1)',
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
