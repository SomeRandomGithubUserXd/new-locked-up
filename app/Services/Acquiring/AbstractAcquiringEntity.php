<?php

namespace App\Services\Acquiring;

use App\Enums\Acquiring\AcquiringCurrencyEnum;
use App\Models\Orders\Order;
use App\Models\Orders\OrderPayment;

abstract class AbstractAcquiringEntity
{
    protected Order $order;

    protected AcquiringCredentialsEntity $credentialsEntity;

    public function __construct(Order $order, AcquiringCredentialsEntity $credentialsEntity)
    {
        $this->order = $order;
        $this->credentialsEntity = $credentialsEntity;
    }

    abstract protected function getBaseUrl(): string;

    protected function buildQuery(string $method, array $params): string
    {
        $url = $this->getBaseUrl();
        if(!str_ends_with($this->getBaseUrl(), '/')) {
            $url .= '/';
        }
        $url .= $method.'?';
        foreach ($params as $key => $value) {
            $url .= "$key=$value&";
        }
        return substr($url, 0, -1);
    }

    abstract public function storePayment(int $amount, AcquiringCurrencyEnum $currencyEnum): OrderPayment;

    abstract public function registerPayment(OrderPayment $orderPayment): string;

    public function constructOrderNumber(): string
    {
        return $this->order->id . '-' . $this->order->orderPayments->count();
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getCredentialsEntity(): AcquiringCredentialsEntity
    {
        return $this->credentialsEntity;
    }
}
