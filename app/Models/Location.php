<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;

    protected $fillable = ['phone', 'email', 'maps', 'latitude', 'longitude', 'additional_email', 'isDeleted', 'name_ru', 'name_en', 'address_ru', 'address_en', 'show_on_child', 'show_on_corporate'];

    protected $casts = [
      'show_on_child' => 'bool',
      'show_on_corporate' => 'bool'
    ];
}