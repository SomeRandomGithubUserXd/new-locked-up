<?php

namespace App\Enums\Orders;

use App\Enums\ISerializableEnum;
use App\Traits\IsSerializableEnum;

enum OrderPaymentStatusEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case created = 0;

    case paid = 1;

    case refunded = 2;

    public function getName(): string
    {
        return match ($this) {
            self::created => 'Создан',
            self::paid => 'Оплачен',
            self::refunded => 'Возвращен',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::created, self::paid => 'white',
            self::refunded => 'white',
        };
    }

    public function getBackgroundColor(): string
    {
        return match ($this) {
            self::created => 'rgba(252, 184, 10, 1)',
            self::paid => 'rgba(76, 161, 84, 1)',
            self::refunded => 'rgba(202, 58, 49, 1)',
        };
    }

    public function toArray(): array
    {
        return [
          'name' => $this->getName(),
          'color' => $this->getColor(),
          'backgroundColor' => $this->getBackgroundColor(),
        ];
    }
}
