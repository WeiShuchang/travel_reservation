<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::guard('web')->check()) {
            $userRole = Auth::user()->role;

            // Redirect based on the user's role
            if ($userRole === $role) {
                return $next($request);
            }

            // Determine redirect route based on user's role
            $redirectRoute = $userRole === 'admin' ? 'administrator' : 'user';

            return redirect()->route($redirectRoute);
        }

        // If user is not authenticated, redirect to login or appropriate page
        return redirect('login'); // You may change this based on your setup
    }
}
