<?php

namespace App\Enums\Acquiring;

use App\Models\Orders\Order;
use App\Services\Acquiring\AbstractAcquiringEntity;
use App\Services\Acquiring\AcquiringCredentialsEntity;
use App\Services\Acquiring\SberBankAcquiringEntity;
use App\Services\Acquiring\YooMoneyAcquiringEntity;
use App\Traits\IsSerializableEnum;

enum AcquiringProviderEnum: string
{
    use IsSerializableEnum;

    case sberBank = SberBankAcquiringEntity::class;

    case yooMoney = YooMoneyAcquiringEntity::class;

    case tinkoff = '';

    public function getInstance(Order $order): AbstractAcquiringEntity
    {
        return match ($this) {
            self::sberBank => new SberBankAcquiringEntity(
                $order,
                new AcquiringCredentialsEntity(
                    config('services.sber_bank_acquiring.username'),
                    config('services.sber_bank_acquiring.password')
                )
            ),
            self::yooMoney => new YooMoneyAcquiringEntity(
                $order,
                new AcquiringCredentialsEntity(
                    config('services.yoo_money_acquiring.username'),
                    config('services.yoo_money_acquiring.password')
                )
            ),
            self::tinkoff => throw new \Exception('To be implemented'),
        };
    }

    public function getCurrency(AcquiringCurrencyEnum $currencyEnum): string|int
    {
        return match ($this) {
            self::sberBank => match ($currencyEnum) {
                AcquiringCurrencyEnum::RUB => 643,
            },
            self::yooMoney => match ($currencyEnum) {
                AcquiringCurrencyEnum::RUB => 'RUB',
            },
            self::tinkoff => match ($currencyEnum) {
                AcquiringCurrencyEnum::RUB => 0,
            },
        };
    }
}
