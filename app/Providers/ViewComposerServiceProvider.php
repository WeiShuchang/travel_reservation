<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user(); // Get the currently authenticated user

            $num_approved_reservations = Reservation::where('is_approved', true)->count();
            $num_pending_reservations = Reservation::where('is_approved', false)
                ->where('is_cancelled', false)
                ->where('is_successful', false)
                ->count();

            $user_approved_reservations = 0;
            $user_pending_reservations = 0;
            $user_successful_reservations = 0;


            // If user is logged in, get the user's reservations
            if ($user) {
                $user_approved_reservations = Reservation::where('is_approved', true)
                    ->where('user_id', $user->id)
                    ->count();

                $user_pending_reservations = Reservation::where('is_approved', false)
                    ->where('user_id', $user->id)
                    ->where('is_cancelled', false)
                    ->where('is_successful', false)
                    ->count();

                $user_successful_reservations = Reservation::where('is_approved', false)
                    ->where('user_id', $user->id)
                    ->where('is_cancelled', false)
                    ->where('is_successful', true)
                    ->count();
            }

            $view->with([
                'num_approved_reservations' => $num_approved_reservations,
                'num_pending_reservations' => $num_pending_reservations,
                'user_approved_reservations' => $user_approved_reservations,
                'user_pending_reservations' => $user_pending_reservations,
                'user_successful_reservations' => $user_successful_reservations,
            ]);
        });
    }

    public function register()
    {
        //
    }
}
