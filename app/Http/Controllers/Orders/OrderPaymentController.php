<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderPaymentRequest;
use App\Models\Orders\Order;

class OrderPaymentController extends Controller
{
    public function index(Order $order)
    {
        return inertia('Orders/Payments/Index', [
            'payments' => [],
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
        $link = '';
        $order->orderPayments()->create($request->validated() + ['link' => $link]);
        return redirect()->route('orders.payments.index', $order->id);
    }
}
