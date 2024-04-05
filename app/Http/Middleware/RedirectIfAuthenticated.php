<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard('web')->check()) {
            $role = Auth::user()->role;
            
            // Determine redirect route based on user's role
            $redirectRoute = $role === 'admin' ? 'administrator' : 'user';
            
            return redirect()->route($redirectRoute);
        }

        return $next($request);
    }
}
