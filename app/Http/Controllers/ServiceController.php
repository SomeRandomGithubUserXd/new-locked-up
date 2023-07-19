<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Requests\Services\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Orders\OrderOption;
use Illuminate\Http\RedirectResponse;

class ServiceController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('Services/Index', [
            'services' => ServiceResource::collection(OrderOption::paginate(15))
        ]);
    }

    public function create()
    {
        return inertia('Services/Create');
    }

    public function store(ServiceRequest $request)
    {
        OrderOption::create($request->validated());
        return redirect()->route('services.index');
    }

    public function show($optionId)
    {
        return inertia('Services/Show', [
            'service' => ServiceResource::singleItem(OrderOption::find($optionId))
        ]);
    }

    public function update($optionId, ServiceRequest $request)
    {
        OrderOption::find($optionId)->update($request->validated());
        return redirect()->route('services.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        OrderOption::whereIn('id', $request->ids)->delete();
        return redirect()->back();
    }
}
