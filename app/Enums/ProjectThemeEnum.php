<?php

namespace App\Enums;

use App\Traits\IsSerializableEnum;

enum ProjectThemeEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case light = 1;

    case dark = 2;

    public function getName(): string
    {
        return match ($this) {
            self::light => 'Светлая',
            self::dark => 'Темная',
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
