<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Orders\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Certificate;
use App\Models\Orders\Order;
use App\Models\Orders\OrderOption;
use App\Models\Orders\OrderSource;
use App\Models\Quest;
use App\Models\Sale;
use App\Traits\InteractsWithOrders;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    use InteractsWithOrders;

    public function index()
    {
        $query = Order::orderByDesc('id')->paginate(15);
        return inertia('Orders/Index', [
            'orders' => OrderResource::collection($query),
            'orderStatuses' => Order::$statuses
        ]);
    }

    public function create()
    {
        return inertia('Orders/Create', $this->getOrderMisc());
    }

    public function show(Order $order)
    {
        return inertia('Orders/Update', [
            'order' => OrderResource::singleItem($order),
            ...$this->getOrderMisc()
        ]);
    }

    public function store(OrderRequest $request)
    {
        $order = Order::create($request->getUnRefactoredValidatedData());
        $order->orderOptions()->sync(collect($request->get('options'))->pluck('id'));
        return redirect()->route('orders.index');
    }

    public function update(Order $order, OrderRequest $request)
    {
        $order->update($request->getUnRefactoredValidatedData());
        $order->orderOptions()->sync(collect($request->get('options'))->pluck('id'));
        return redirect()->route('orders.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Order::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
