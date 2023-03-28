<?php

namespace App\Http\Controllers;

use App\Models\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        return inertia('Settings/Index', [
            'settings' => Settings::get()
        ]);
    }
}
