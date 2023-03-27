<?php

namespace App\Enums;

use App\Traits\IsSerializableEnum;

enum ScheduleTypeEnum: string implements ISerializableEnum
{
    use IsSerializableEnum;

    case weekdays = 'weekdays';

    case friday = 'friday';

    case weekend = 'weekend';

    public function getName(): string
    {
        return match ($this) {
            self::weekdays => 'Будни',
            self::friday => 'Пятница',
            self::weekend => 'Выходные',
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
