<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    public $timestamps = false;

    protected $fillable = ['phone', 'email', 'maps', 'latitude', 'longitude', 'additional_email', 'isDeleted', 'name_ru', 'name_en', 'address_ru', 'address_en', 'show_on_child', 'show_on_corporate'];

    protected $casts = [
      'show_on_child' => 'bool',
      'show_on_corporate' => 'bool'
    ];

    public function locationLounges(): HasMany
    {
        return $this->hasMany(LocationLounge::class, 'location_id');
    }
}
