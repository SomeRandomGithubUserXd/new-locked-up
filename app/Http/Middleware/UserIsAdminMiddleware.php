<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use Closure;
use Illuminate\Http\Request;

class UserIsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check()) {
            abort_if(auth()->user()->role !== UserRoleEnum::user, 403);
        }
        return $next($request);
    }
}
