<?php

namespace App\Observers;

use App\Models\Quest;
use Carbon\Carbon;

class QuestObserver
{
    public function created(Quest $quest): void
    {

    }

    public function updated(Quest $quest): void
    {
    }

    public function deleted(Quest $quest): void
    {

    }

    public function restored(Quest $quest): void
    {
    }

    public function forceDeleted(Quest $quest): void
    {
    }
}
