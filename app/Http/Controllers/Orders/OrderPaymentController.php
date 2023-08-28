<?php

namespace App\Http\Controllers\Orders;

use App\Enums\Acquiring\AcquiringCurrencyEnum;
use App\Enums\Acquiring\AcquiringProviderEnum;
use App\Enums\Orders\OrderPaymentStatusEnum;
use App\Enums\Orders\OrderPaymentTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderPaymentRequest;
use App\Http\Resources\Orders\OrderPaymentResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderPayment;
use App\Services\Acquiring\AcquiringService;
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

    public function register(OrderPayment $orderPayment)
    {
        $service = new AcquiringService($orderPayment->order, AcquiringProviderEnum::yooMoney);
        $url = $service->getAcquiringEntity()->registerPayment($orderPayment, AcquiringCurrencyEnum::RUB);
        $orderPayment->update(['link' => $url]);
        return redirect()->back()->with('lastOrderPaymentLink', $url);
    }

    public function orderPaid(Request $request)
    {
        if($id = $request->order_payment) {
            OrderPayment::firstWhere(['id' => $id])->update(['status' => OrderPaymentStatusEnum::paid]);
        }
        return "Оплачено";
    }
}
