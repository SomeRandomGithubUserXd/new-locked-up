<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Orders\Order;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::orderByDesc('date')->paginate(30);
        return inertia('Orders/Index', [
            'orders' => OrderResource::collection($query),
            'order_statuses' => Order::$statuses
        ]);
    }
}
