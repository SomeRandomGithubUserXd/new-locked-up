<?php

namespace App\Models;

use App\Casts\ChangeEventItemCast;
use Illuminate\Database\Eloquent\Model;

abstract class ChangeLogItem extends Model
{
    protected $fillable = ['user_id', 'change_event'];

    protected $casts = [
        'change_event' => ChangeEventItemCast::class
    ];
}
