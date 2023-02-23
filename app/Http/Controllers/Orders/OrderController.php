<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders\Order;

class OrderController extends Controller
{
    public function index()
    {
        return inertia('Orders/Index', [
            'orders' => Order::paginate(15)
        ]);
    }
}
