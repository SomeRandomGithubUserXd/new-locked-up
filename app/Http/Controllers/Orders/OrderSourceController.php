<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Orders\OrderSourceRequest;
use App\Http\Resources\Orders\OrderSourceResource;
use App\Models\Orders\OrderSource;
use Illuminate\Http\RedirectResponse;

class OrderSourceController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('OrderSources/Index', [
            'sources' => OrderSourceResource::collection(OrderSource::paginate(15))
        ]);
    }

    public function show(OrderSource $orderSource)
    {
        return inertia('OrderSources/Show', [
            'source' => OrderSourceResource::singleItem($orderSource)
        ]);
    }

    public function create()
    {
        return inertia('OrderSources/Create');
    }

    public function update(OrderSource $orderSource, OrderSourceRequest $request)
    {
        $orderSource->update($request->validated());
        return redirect()->route('order-sources.index');
    }

    public function store(OrderSourceRequest $request)
    {
        OrderSource::create($request->validated());
        return redirect()->route('order-sources.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        OrderSource::whereIn('id', $request->get('ids'))->delete();
        return redirect()->back();
    }
}
