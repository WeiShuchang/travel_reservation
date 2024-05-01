<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectIfAuthenticated;

use App\Http\Middleware\RestrictUserAccess;
use App\Http\Middleware\RestrictAdminAccess;
use Illuminate\Support\Facades\Redirect;

Route::get('', function () {return view('home/home');})->name('home')->middleware(RedirectifAuthenticated::class);



    require __DIR__.'/auth.php';

    Route::middleware('auth')->group(function () {

    Route::middleware([RedirectIfAuthenticated::class])->group(function () {
       
    });

    Route::get('/reservations/my_reservations', [ReservationController::class, 'my_reservations'])->name('reservation.my_reservations')->middleware(RestrictAdminAccess::class);
    Route::get('/reservations/{reservation_id}/edit_for_user', [ReservationController::class, 'edit_for_user'])->name('reservation.edit_for_user')->middleware(RestrictAdminAccess::class);
    Route::get('/reservations_detail/{id}', [ReservationController::class, 'show_details'])->name('reservation.show_details')->middleware(RestrictAdminAccess::class);
    Route::get('/reservations_history', [ReservationController::class, 'show_history'])->name('reservation.show_history')->middleware(RestrictAdminAccess::class);

    Route::resource('/reservation', ReservationController::class)->only(['create','store','my_reservations','edit_for_user', 'update_for_user' ,'cancel'])->middleware(RestrictAdminAccess::class);
    Route::resource('/reservation', ReservationController::class)->only(['edit','update','approved','index', 'show_cancelled','complete'])->middleware(RestrictUserAccess::class);
    Route::get('/reservations_detail/{id}', [ReservationController::class, 'show_details'])->name('reservation.show_details');
    Route::get('/reservations_history', [ReservationController::class, 'show_history'])->name('reservation.show_history');

    Route::get('/administrator', function () {return view('administrator.admin_home');})->name('administrator')->middleware(RestrictUserAccess::class);
    Route::resource('/drivers_inventory', DriverController::class)->middleware(RestrictUserAccess::class);
    Route::resource('/cars_inventory', CarController::class)->middleware(RestrictUserAccess::class);
    Route::get('/reservations/approved', [ReservationController::class, 'approved'])->name('reservation.approved')->middleware(RestrictUserAccess::class);
    Route::get('/reservations/cancelled', [ReservationController::class, 'show_cancelled'])->name('reservation.show_cancelled')->middleware(RestrictUserAccess::class);
    Route::get('/reservations/completed', [ReservationController::class, 'show_completed'])->name('reservation.show_completed')->middleware(RestrictUserAccess::class);
    Route::get('/reservations/search', [ReservationController::class, 'search'])->name('completed.reservations.search')->middleware(RestrictUserAccess::class);
    Route::get('/reservations/export', [ReservationController::class, 'exportCompletedTravels'])->name('completed.reservations.export')->middleware(RestrictUserAccess::class);
    Route::put('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::put('/reservations/{reservation}/complete', [ReservationController::class, 'complete'])->name('reservations.complete')->middleware(RestrictUserAccess::class);
    Route::delete('/reservations/{reservation}/delete', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    Route::get('/user', function(){return view('user.user_home');})->name('user')->middleware(RestrictAdminAccess::class);
    Route::get('/reservations/available', [ReservationController::class, 'show_available'])->name('reservation.show_available');
    Route::get('/reservations/user_approved', [ReservationController::class, 'user_approved'])->name('reservation.user_approved');
    Route::get('/reservations/modal_closed', [ReservationController::class, 'modalClosed'])->name('reservation.modal_closed');        
    Route::put('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::put('/reservation/{id}/update', [ReservationController::class, 'reservation_update_user'])->name('reservation.reservation_update_user');

    
});







