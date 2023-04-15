<?php

namespace App\Enums;

use App\Enums\ISerializableEnum;
use App\Traits\IsSerializableEnum;

enum UserRoleEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case user = 0;

    public function getName(): string
    {
        return match ($this) {
            self::user => 'Пользователь',
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