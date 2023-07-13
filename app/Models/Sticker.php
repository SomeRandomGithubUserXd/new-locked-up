<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sticker extends Model
{
    protected $fillable = ['name', 'alt', 'text', 'color'];

    // TODO: add photos through spatie stuff
}
