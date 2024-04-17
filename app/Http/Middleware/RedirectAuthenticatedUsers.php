<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAuthenticatedUsers
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->route('administrator');
            } elseif ($role === 'user') {
                return redirect()->route('user');
            }
        }

        return $next($request);
    }
}
