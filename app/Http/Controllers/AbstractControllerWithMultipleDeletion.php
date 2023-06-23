<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\ActionWithManyRequest;
use Illuminate\Http\RedirectResponse;

abstract class AbstractControllerWithMultipleDeletion extends Controller
{
    public string $name;

    public function __construct(string $name = '')
    {
        parent::__construct();
        $this->name = $name;
    }

    abstract public function destroyMany(ActionWithManyRequest $request): RedirectResponse;

    public function toArray(): array
    {
        return [$this->name => get_class($this)];
    }
}
