<?php

namespace App\Enums\Acquiring;

use App\Services\Acquiring\AbstractAcquiringEntity;
use App\Services\Acquiring\SberBankAcquiringEntity;
use App\Traits\IsSerializableEnum;

enum AcquiringCurrencyEnum: int
{
    use IsSerializableEnum;

    case RUB = 0;
}
