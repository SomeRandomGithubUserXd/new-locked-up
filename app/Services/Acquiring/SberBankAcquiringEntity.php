<?php

namespace App\Services\Acquiring;

use App\Enums\Acquiring\AcquiringCurrencyEnum;
use App\Enums\Acquiring\AcquiringProviderEnum;
use App\Enums\Orders\OrderPaymentStatusEnum;
use App\Models\Orders\OrderPayment;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;

class SberBankAcquiringEntity extends AbstractAcquiringEntity
{
    protected function getBaseUrl(): string
    {
        return "https://3dsec.sberbank.ru/payment/rest";
    }

    protected function formRequest(string $url): PromiseInterface|Response
    {
        return \Http::asForm()
            ->withOptions(["verify" => false])
            ->post($url, [
                'userName' => $this->credentialsEntity->getUsername(),
                'password' => $this->credentialsEntity->getPassword(),
            ]);
    }

    public function storePayment(int $amount, AcquiringCurrencyEnum $currencyEnum): OrderPayment
    {
        $url = $this->buildQuery('register.do', [
            'amount' => $amount,
            'currency' => AcquiringProviderEnum::sberBank->getCurrency($currencyEnum),
            'language' => 'ru',
            'orderNumber' => $orderNumber = $this->constructOrderNumber(),
            'returnUrl' => route('order-paid', ['order_payment' => $orderNumber]),
        ]);
        $response = $this->formRequest($url)->json();
        return $this->order->orderPayments()->create([
            'id_from_provider' => $response['orderId'],
            'order_number' => $orderNumber,
            'link' => $response['formUrl'],
            'sum' => $amount
        ]);
    }



    public function registerPayment(OrderPayment $orderPayment): string
    {
        $orderPayment->update(['link' => $url = \Str::random()]);
        return $url;
        $url = $this->buildQuery('register.do', [
            'amount' => $orderPayment->sum,
            'currency' => AcquiringProviderEnum::sberBank->getCurrency($orderPayment->currency),
            'language' => 'ru',
            'orderNumber' => $orderNumber = $this->constructOrderNumber(),
            'returnUrl' => route('order-paid', ['order_payment' => $orderNumber]),
        ]);
        $response = $this->formRequest($url)->json();
        $orderPayment->update(['link' => $url = $response['formUrl']]);
        return $url;
    }

    public function refund(OrderPayment $orderPayment): bool
    {
        $url = $this->buildQuery('refund.do', [
            'orderId' => $orderPayment->id_from_provider,
            'amount' => $amount = $orderPayment->sum
        ]);
        $response = $this->formRequest($url)->json();
        if ((int)$response['errorCode'] == 0) {
            $orderPayment->update([
                'status' => OrderPaymentStatusEnum::refunded,
                'returned' => $amount
            ]);
            return true;
        }
        return false;
    }
}
