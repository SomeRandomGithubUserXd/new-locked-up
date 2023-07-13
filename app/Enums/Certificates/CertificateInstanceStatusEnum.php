<?php

namespace App\Enums\Certificates;

use App\Enums\ISerializableEnum;
use App\Traits\IsSerializableEnum;

enum CertificateInstanceStatusEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case booked = 0;

    case active = 1;

    case redeemed = 2;

    public function getName(): string
    {
        return match ($this) {
            self::booked => 'Забронирован',
            self::active => 'Активен',
            self::redeemed => 'Использован',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::booked, self::active => 'rgb(0, 128, 0)',
            self::redeemed => 'red',
        };
    }

    public function toArray(): array
    {
        return [
            'key' => $this->value,
            'name' => $this->getName(),
            'color' => $this->getColor(),
        ];
    }
}
