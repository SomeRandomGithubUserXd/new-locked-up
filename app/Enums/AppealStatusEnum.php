<?php

namespace App\Enums;

use App\Traits\IsSerializableEnum;

enum AppealStatusEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case new = 0;

    case in_progress = 1;

    case booked = 2;

    case canceled = 3;

    public function getName(): string
    {
        return match ($this) {
            self::new => 'Новый',
            self::in_progress => 'В работе',
            self::booked => 'Забронирован',
            self::canceled => 'Отменен',
        };
    }

    public function toArray(): array
    {
        return [
            'key' => $this->value,
            'name' => $this->getName()
        ];
    }
}
