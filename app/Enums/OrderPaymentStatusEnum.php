<?php

namespace App\Enums;

enum OrderPaymentStatusEnum: int
{
    case created = 0;

    case payed = 1;

    public function getName(): string
    {
        return match ($this) {
            self::created => 'Создан',
            self::payed => 'Оплачен',
        };
    }
}
