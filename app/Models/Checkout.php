<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = ['name', 'client_id', 'is_active', 'is_shown', 'type_id'];
}
