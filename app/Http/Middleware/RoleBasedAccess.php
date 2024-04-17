<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleBasedAccess
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user || !$user->hasAnyRole(...$roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
