<?php

namespace App\Models\Orders;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderOption extends Model
{
    protected $fillable = [
        'name_ru',
        'name_en',
        'price',
        'is_internal',
        'is_active',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orders_order_options')->using(OrderQuestOption::class);
    }
}
