<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\ActionWithManyRequest;
use Illuminate\Http\RedirectResponse;

class ServiceController extends AbstractControllerWithMultipleDeletion
{
    public function index()
    {
        return inertia('Services/Index');
    }

    public function destroyMany(ActionWithManyRequest $request): RedirectResponse
    {
        return redirect()->back();
    }
}
