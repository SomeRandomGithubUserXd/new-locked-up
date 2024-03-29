<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Requests\Locations\LocationRequest;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\Locations\LocationResource;
use App\Models\Locations\Location;
use Illuminate\Http\RedirectResponse;

class LocationController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        $locations = LocationResource::collection(Location::paginate(15));
        return inertia('Locations/Index', [
            'locations' => $locations
        ]);
    }

    public function create()
    {
        return inertia('Locations/Create');
    }

    public function store(LocationRequest $request)
    {
        Location::create($request->validated());
        return redirect()->route('locations.index');
    }

    public function show(Location $location)
    {
        return inertia('Locations/Show', [
            'location' => LocationResource::singleItem($location)
        ]);
    }

    public function update(Location $location, LocationRequest $request)
    {
        $location->update($request->validated());
        return redirect()->route('locations.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Location::whereIn('id', $request->ids)->delete();
        return redirect()->back();
    }
}
