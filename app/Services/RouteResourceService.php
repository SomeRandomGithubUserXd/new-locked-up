<?php

namespace App\Services;

use App\Http\Controllers\AbstractControllerWithMultipleDeletion;
use Route;
use Str;

class RouteResourceService
{
    public static function resourceWithMultipleDeletion(AbstractControllerWithMultipleDeletion ...$entities): void
    {
        Route::resources(array_merge(...array_map(static function ($obj) {
            return $obj->toArray();
        }, $entities)));
        foreach ($entities as $controller) {
            $name = $controller->name;
            Route::group(['prefix' => Str::snake($name), 'as' => Str::camel($name) . '.'], static function () use ($controller) {
                Route::post('delete_many', [$controller::class, 'destroyMany'])->name('destroy-many');
            });
        }
    }
}
