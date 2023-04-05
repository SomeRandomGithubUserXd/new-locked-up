<?php

namespace App\Http\Controllers\Lounges;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lounges\LoungeRequest;
use App\Http\Requests\Orders\ActionWithManyRequest;
use App\Http\Resources\Lounges\LoungeResource;
use App\Models\Lounges\Lounge;
use App\Models\Lounges\LoungeSchedule;
use Illuminate\Http\RedirectResponse;

class LoungeController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('Lounges/Index', [
            'lounges' => LoungeResource::collection(Lounge::paginate(15))
        ]);
    }

    public function show(Lounge $lounge)
    {
        return inertia('Lounges/Show', [
            'lounge' => LoungeResource::singleItem($lounge),
            'loungeSchedules' => LoungeSchedule::all()
        ]);
    }

    public function create(Lounge $lounge)
    {
        return inertia('Lounges/Create', [
            'lounge' => LoungeResource::singleItem($lounge),
            'loungeSchedules' => LoungeSchedule::all()
        ]);
    }

    public function store(LoungeRequest $request)
    {
        Lounge::create($request->validated());
        return redirect()->route('lounges.index');
    }

    public function update(Lounge $lounge, LoungeRequest $request)
    {
        $lounge->update($request->validated());
        return redirect()->route('lounges.index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        Lounge::whereIn('id', $request->get('ids'));
        return redirect()->back();
    }
}
