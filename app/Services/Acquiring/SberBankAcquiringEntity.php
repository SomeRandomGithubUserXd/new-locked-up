<?php

namespace App\Services\Acquiring;

use App\Enums\Acquiring\AcquiringCurrencyEnum;
use App\Enums\Acquiring\AcquiringProviderEnum;
use App\Models\Orders\OrderPayment;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;

class SberBankAcquiringEntity extends AbstractAcquiringEntity
{
    protected function getBaseUrl(): string
    {
        return "http://3dsec.sberbank.ru/payment/rest";
    }

    protected function formRequest(string $url): PromiseInterface|Response
    {
        return \Http::asForm()->post($url, [
            'userName' => $this->credentialsEntity->getUsername(),
            'password' => $this->credentialsEntity->getPassword(),
        ]);
    }

    public function storePayment(int $amount, AcquiringCurrencyEnum $currencyEnum): OrderPayment
    {
        $orderNumber = $this->order->id.'-'.OrderPayment::where(['order_id' => $this->order->id])->count();
        $url = $this->buildQuery('register.do', [
            'amount' => $amount,
            'currency' => AcquiringProviderEnum::sberBank->getCurrency($currencyEnum),
            'language' => 'ru',
            'orderNumber' => $orderNumber,
            'returnUrl' => route('order-payed', ['order_payment' => $orderNumber]),
        ]);
        $response = $this->formRequest($url)->json();
        return $this->order->orderPayments()->create([
            'id_from_provider' => $response['orderId'],
            'order_number' => $orderNumber,
            'link' => $response['formUrl'],
            'sum' => $amount
        ]);
    }
}
