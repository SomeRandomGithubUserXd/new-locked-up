<?php

namespace App\Models;

use App\Models\Quests\Quest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'review_date',
        'name',
        'rate',
        'review',
        'quest_id',
        'is_approved',
        'language',
    ];

    protected $casts = [
        'review_date' => 'date',
        'is_approved' => 'bool'
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
