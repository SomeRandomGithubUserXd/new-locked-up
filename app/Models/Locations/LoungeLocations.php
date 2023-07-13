<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoungeLocations extends Model
{
    protected $fillable = ['location_id', 'name_ru', 'name_en', 'description_ru', 'description_en'];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
