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
        'price',
        'active',
        'isDeleted',
        'name_ru',
        'name_en',
        'inner'
    ];

    public function price(): Attribute
    {
        return Attribute::make(
            get: static fn ($value) => $value ?? 0
        );
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_order_options')->using(OrderQuestOption::class);
    }
}
