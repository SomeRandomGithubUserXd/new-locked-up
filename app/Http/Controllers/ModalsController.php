<?php

namespace App\Http\Controllers;

use App\Http\Requests\Modals\AdvertModalRequest;
use App\Models\Modals\AdvertModal;

class ModalsController extends Controller
{
    public function main()
    {
        return inertia('Modals/Main', [
            'advertModal' => AdvertModal::first()
        ]);
    }

    public function updateAdvertModal(AdvertModalRequest $request)
    {
        AdvertModal::first()->update($request->validated());
        return redirect()->route('modals.main');
    }
}
