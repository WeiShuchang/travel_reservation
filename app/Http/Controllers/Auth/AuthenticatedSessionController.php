<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {   
       
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate user
        $request->authenticate();

        // Regenerate session
        $request->session()->regenerate();


        // Determine redirect route based on user's role
        $redirectRoute = Auth::user()->role === 'admin' ? 'administrator' : 'user';

        return redirect()->intended(route($redirectRoute, [], false))->with('success', 'You have been successfully logged in!');;
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Check if the user is authenticated before logging them out
        if (Auth::check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Set success message
           
        }

        return redirect('login')->with('success', 'Logged Out Successfully!');
    }

}
