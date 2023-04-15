<?php

namespace App\Casts;

use App\Services\ChangeEventItem;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ChangeEventItemCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        return $value;
    }

    /**
     * @param Model $model
     * @param string $key
     * @param ChangeEventItem $value
     * @param array $attributes
     * @return string
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (!is_a($value, ChangeEventItem::class)) throw new \TypeError("Use " . ChangeEventItem::class);
        return $value->toString();
    }
}
