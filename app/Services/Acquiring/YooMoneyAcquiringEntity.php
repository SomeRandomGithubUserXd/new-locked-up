<?php

namespace App\Services\Acquiring;

use App\Enums\Acquiring\AcquiringCurrencyEnum;
use App\Enums\Acquiring\AcquiringProviderEnum;
use App\Models\Orders\OrderPayment;
use YooKassa\Client;

class YooMoneyAcquiringEntity extends AbstractAcquiringEntity
{

    protected function getBase(): Client
    {
        $client = new Client();
        $client->setAuth($this->credentialsEntity->getUsername(), $this->credentialsEntity->getPassword());
        return $client;
    }

    public function storePayment(int $amount, AcquiringCurrencyEnum $currencyEnum): OrderPayment
    {

    }

    public function registerPayment(OrderPayment $orderPayment, AcquiringCurrencyEnum $currencyEnum): string
    {
        $payment = $this->getBase()->createPayment(
            array(
                'amount' => array(
                    'value' => $orderPayment->sum,
                    'currency' => AcquiringProviderEnum::yooMoney->getCurrency($currencyEnum),
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => route('order-paid', ['order_payment' => $orderPayment->id]),
                ),
                'capture' => true,
                'description' => '',
            ),
            uniqid('', true)
        );
        return $payment->getConfirmation()->getConfirmationUrl();
    }
}
