<?php

// app/Providers/ViewComposerServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Reservation;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $num_approved_reservations = Reservation::where('is_approved', true)->count();
            $num_pending_reservations = Reservation::where('is_approved', false)
            ->where('is_cancelled',false)->where('is_successful', false)->count();
            $view->with('num_approved_reservations', $num_approved_reservations)->with('num_pending_reservations', $num_pending_reservations);
        });
    }

    public function register()
    {
        //
    }
}
