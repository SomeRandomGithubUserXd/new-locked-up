<?php

namespace App\Enums\Certificates;

use App\Enums\ISerializableEnum;
use App\Traits\IsSerializableEnum;

enum CertificateInstanceTypeEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case fixedValue = 0;

    case percentOf = 1;
    case imputedCost = 2;

    public function getName(): string
    {
        return match ($this) {
            self::fixedValue => 'Фиксированная стоимость, руб.',
            self::percentOf => 'Процент, %',
            self::imputedCost => 'Вмененная сумма',
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
