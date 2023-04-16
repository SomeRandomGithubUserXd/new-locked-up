<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait QueryTools
{
    public function getWhereLikeManyQuery(EloquentBuilder|QueryBuilder $query, array $fields, string $string): EloquentBuilder|QueryBuilder
    {
        foreach ($fields as $field) {
            $query->orWhere($field, 'like', '%' . $string . '%');
        }
        return $query;
    }
}
