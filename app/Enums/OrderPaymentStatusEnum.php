<?php

namespace App\Enums;

enum OrderPaymentStatusEnum: int
{
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
}
