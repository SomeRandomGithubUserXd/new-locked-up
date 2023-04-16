<?php

namespace App\Enums;

use App\Traits\IsSerializableEnum;

enum QuestDifficultyLevelEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case easy = 0;

    case medium = 1;

    case hard = 2;

    public function getName(): string
    {
        return match ($this) {
            self::easy => 'Легкий',
            self::medium => 'Средний',
            self::hard => 'Сложный',
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
