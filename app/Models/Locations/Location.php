<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'name_ru',
        'name_en',
        'address_ru',
        'address_en',
        'phone',
        'email',
        'latitude',
        'longitude',
        'additional_email',
        'show_at_kids_page',
        'show_at_corporate_parties_page'
    ];

    protected $casts = [
        'show_at_kids_page' => 'bool',
        'show_at_corporate_parties_page' => 'bool'
    ];

    public function loungeLocations(): HasMany
    {
        return $this->hasMany(LoungeLocations::class, 'location_id');
    }
}
