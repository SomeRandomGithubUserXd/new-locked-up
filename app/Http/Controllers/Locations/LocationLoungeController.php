<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Locations\LocationLoungeRequest;
use App\Models\Locations\Location;
use App\Models\Locations\LocationLounge;

class LocationLoungeController extends Controller
{
    public function create(Location $location)
    {
        return inertia('Locations/Lounges/Create', [
            'locationId' => $location->id,
        ]);
    }

    public function show(Location $location, LocationLounge $locationLounge)
    {
        return inertia('Locations/Lounges/Show', [
            'locationId' => $location->id,
            'lounge' => $locationLounge,
        ]);
    }

    public function store(Location $location, LocationLoungeRequest $request)
    {
        $location->locationLounges()->create($request->validated());
        return redirect()->route('locations.show', $location->id);
    }

    public function update(Location $location, LocationLounge $locationLounge, LocationLoungeRequest $request)
    {
        $locationLounge->update($request->validated());
        return redirect()->route('locations.show', $location->id);
    }

    public function destroy(Location $location, LocationLounge $locationLounge)
    {
        $locationLounge->delete();
        return redirect()->route('locations.show', $location->id);
    }
}
