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

    abstract protected function getBase(): mixed;

    protected function buildQuery(string $method, array $params): string
    {
        $url = $this->getBase();
        if(!is_string($url)) return "";
        if(!str_ends_with($this->getBase(), '/')) {
            $url .= '/';
        }
        $url .= $method.'?';
        foreach ($params as $key => $value) {
            $url .= "$key=$value&";
        }
        return substr($url, 0, -1);
    }

    abstract public function storePayment(int $amount, AcquiringCurrencyEnum $currencyEnum): OrderPayment;

    abstract public function registerPayment(OrderPayment $orderPayment, AcquiringCurrencyEnum $currencyEnum): string;

    public function constructOrderNumber(): string
    {
        // TODO: deprecated
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
