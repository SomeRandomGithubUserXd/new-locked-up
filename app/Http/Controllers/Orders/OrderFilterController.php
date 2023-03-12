<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Orders\FilterEntityRequest;
use App\Http\Resources\OrderFilterResource;
use App\Models\Certificate;
use App\Models\Orders\OrderFilter;
use App\Traits\InteractsWithOrders;
use Illuminate\Http\RedirectResponse;

class OrderFilterController extends AbstractControllerWithMultipleDeletion
{
    use InteractsWithOrders;

    public function index()
    {
        return inertia('OrderFilters/Index', [
            'filters' => OrderFilterResource::collection(OrderFilter::paginate(15))
        ]);
    }

    public function create()
    {
        return inertia('OrderFilters/Create', $this->getOrderMisc());
    }

    public function show(OrderFilter $orderFilter)
    {
        return inertia('OrderFilters/Show', [
            'filter' => $orderFilter,
            ...$this->getOrderMisc()
        ]);
    }

    public function update(FilterEntityRequest $request, OrderFilter $orderFilter)
    {
        $orderFilter->update($request->validated());
        return redirect()->route('order-filters.index');
    }

    public function store(FilterEntityRequest $request)
    {
        OrderFilter::create($request->validated());
        return redirect()->route('order-filters.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        OrderFilter::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
