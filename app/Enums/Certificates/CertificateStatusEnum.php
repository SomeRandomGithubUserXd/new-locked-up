<?php

namespace App\Enums\Certificates;

use App\Enums\ISerializableEnum;
use App\Traits\IsSerializableEnum;

enum CertificateStatusEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case new = 0;

    case canceled = 1;

    case covered = 2;

    case pending = 3;

    case redeemed = 4;

    public function getName(): string
    {
        return match ($this) {
            self::new => 'Новый',
            self::canceled => 'Отмененный',
            self::covered => 'Оплаченный',
            self::pending => 'Ожидающий оплаты',
            self::redeemed => 'Погашеный',
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
