<?php

namespace App\Enums;

enum ChangeEventEnum: int
{
    case created = 1;

    case updated = 2;

    case deleted = 3;

    case restored = 5;

    case forceDeleted = 6;

    public function getName(): string
    {
        return match ($this) {
            self::created => 'Создан',
            self::updated => 'Обновлен',
            self::deleted => 'Удален',
            self::restored => 'Восстановлен',
            self::forceDeleted => 'Удален принудительно',
        };
    }

    public function needsDescription(): bool
    {
        return match ($this) {
            self::created, self::restored, self::forceDeleted, self::deleted => false,
            self::updated => true,
        };
    }
}
