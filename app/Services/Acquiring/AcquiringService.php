<?php

namespace App\Services\Acquiring;

use App\Enums\Acquiring\AcquiringProviderEnum;
use App\Models\Orders\Order;

class AcquiringService
{
    protected AbstractAcquiringEntity $acquiringEntity;

    public function __construct(Order $order, AcquiringProviderEnum $providerEnum)
    {
        $this->acquiringEntity = $providerEnum->getInstance($order);
    }

    public function getAcquiringEntity(): AbstractAcquiringEntity
    {
        return $this->acquiringEntity;
    }
}
