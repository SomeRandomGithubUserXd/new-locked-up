<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class NewsQuests extends Pivot
{
    protected $table = 'news_quests';

    public $timestamps = false;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderOption(): BelongsTo
    {
        return $this->belongsTo(OrderOption::class, 'order_option_id');
    }
}
