<?php

namespace App\Enums;

use App\Enums\ISerializableEnum;
use App\Traits\IsSerializableEnum;

enum UserRoleEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case webmaster = 0;

    case viewer = 1;

    case admin = 2;

    case callCenter = 3;

    case contentManager = 4;

    public function getName(): string
    {
        return match ($this) {
            self::webmaster => 'Webmaster',
            self::viewer => 'Зритель',
            self::admin => 'Администратор',
            self::callCenter => 'Колл-центр',
            self::contentManager => 'Контент-менеджер',
        };
    }

    public function toArray(): array
    {
        return [
            'key' => $this->value,
            'name' => $this->getName(),
        ];
    }
}
