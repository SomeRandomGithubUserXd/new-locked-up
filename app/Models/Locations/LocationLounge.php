<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationLounge extends Model
{
    protected $table = 'location_lounge';

    protected $fillable = ['name_ru', 'name_en', 'description_ru', 'description_en'];

    public $timestamps = false;

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
