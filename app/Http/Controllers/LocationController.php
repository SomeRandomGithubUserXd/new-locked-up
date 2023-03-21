<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
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

    public function show(Location $location)
    {
        return inertia('Locations/Show', [
            'location' => LocationResource::singleItem($location)
        ]);
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Location::whereIn('id', $request->ids)->delete();
        return redirect()->back();
    }
}
