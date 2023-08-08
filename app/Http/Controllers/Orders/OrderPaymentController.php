<?php

namespace App\Http\Controllers\Orders;

use App\Enums\Acquiring\AcquiringCurrencyEnum;
use App\Enums\Acquiring\AcquiringProviderEnum;
use App\Enums\OrderPaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderPaymentRequest;
use App\Http\Resources\Orders\OrderPaymentResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderPayment;
use App\Services\Acquiring\AcquiringService;
use App\Services\Acquiring\SberBankAcquiringEntity;
use Illuminate\Http\Request;

class OrderPaymentController extends Controller
{
    public function index(Order $order)
    {
        return inertia('Orders/Payments/Index', [
            'payments' => OrderPaymentResource::collection($order->orderPayments()->paginate()),
            'order' => $order
        ]);
    }

    public function create(Order $order)
    {
        return inertia('Orders/Payments/Create', [
            'order' => $order
        ]);
    }

    public function store(Order $order, OrderPaymentRequest $request)
    {
        $sum = (float)$request->get('sum') * 100;
        $service = new AcquiringService($order, AcquiringProviderEnum::sberBank);
        $service->getAcquiringEntity()->storePayment($sum, AcquiringCurrencyEnum::RUB);
        return redirect()->route('orders.payments.index', $order->id);
    }

    public function refund(Order $order, OrderPayment $orderPayment)
    {
        if ($orderPayment->status !== OrderPaymentStatusEnum::paid) {
            return redirect()->back();
        }
        $service = new AcquiringService($order, AcquiringProviderEnum::sberBank);
        $service->getAcquiringEntity()->refund($orderPayment);
        return redirect()->route('orders.payments.index', $order->id);
    }

    public function orderpaid(Request $request)
    {
        OrderPayment::firstWhere(['id_from_provider' => $request->orderId])->update(['status' => OrderPaymentStatusEnum::paid]);
        return "Оплачено";
    }
}
