<?php

namespace App\Models\Sales;

use App\Models\Quests\Quest;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SaleQuest extends Pivot
{
    protected $table = 'sales_quests';

    public $timestamps = false;

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class, 'quests_id', 'id');
    }
}
