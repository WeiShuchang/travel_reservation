<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectAuthenticatedUsers;
use App\Http\Middleware\RedirectBasedOnRole;
use App\Http\Middleware\NoCacheMiddleware;
use App\Http\Middleware\RestrictUserAccess;
use App\Http\Middleware\RestrictAdminAccess;
use Illuminate\Support\Facades\Redirect;

Route::get('', function () {return view('home/home');})->name('home')->middleware(RedirectIfAuthenticated::class);

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/reservation', ReservationController::class)->only(['create','store','my_reservations'])->middleware(RestrictAdminAccess::class);
    Route::resource('/reservation', ReservationController::class)->only(['edit','update','approved','index', 'show_cancelled', 'destroy','complete','cancel'])->middleware(RestrictUserAccess::class);
    Route::get('/reservations/my_reservations', [ReservationController::class, 'my_reservations'])->name('reservation.my_reservations')->middleware(RestrictAdminAccess::class);;

    // Administrator Routes
    Route::middleware([RedirectBasedOnRole::class . ':admin'])->group(function () {
        Route::middleware(NoCacheMiddleware::class)->group(function () {
            // Administrator Routes
            Route::get('/administrator', function () {
                return view('administrator.admin_home');
            })->name('administrator');
            Route::resource('/drivers_inventory', DriverController::class);
            Route::resource('/cars_inventory', CarController::class);
            Route::get('/reservations/approved', [ReservationController::class, 'approved'])->name('reservation.approved');
          
            Route::get('/reservations/cancelled', [ReservationController::class, 'show_cancelled'])->name('reservation.show_cancelled');
            Route::get('/reservations/completed', [ReservationController::class, 'show_completed'])->name('reservation.show_completed');
            Route::put('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
            Route::put('/reservations/{reservation}/complete', [ReservationController::class, 'complete'])->name('reservations.complete');
            Route::delete('/reservations/{reservation}/delete', [ReservationController::class, 'destroy'])->name('reservations.destroy');
        });
    });

    // User Routes
    Route::middleware([RedirectBasedOnRole::class . ':user'])->group(function () {
        Route::middleware(NoCacheMiddleware::class)->group(function () {
         
            Route::get('/user', function(){
                return view('user.user_home');
            })->name('user');
           
            
        });
    });

});




