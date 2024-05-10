<?php


use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\CarController;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RestrictUserAccess;
use App\Http\Middleware\RestrictAdminAccess;

Route::middleware([PreventBackHistory::class])->group(function(){

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('', function () {return view('home/home');})->name('home');
});
Route::put('/reservation_cancel/{reservation}/', [ReservationController::class, 'cancel_reservation_for_user'])->name('reservation.cancel_for_user');
Route::get('/reservations/my_reservations', [ReservationController::class, 'my_reservations'])->name('reservation.my_reservations');

Route::middleware('auth')->group(function () {


    Route::put('/reservation/{reservation}/cancel_reservation', [ReservationController::class, 'cancel_reservation'])->name('reservation.cancel');

    Route::middleware([RestrictAdminAccess::class])->group(function () {

        Route::get('/reservations/{reservation_id}/edit_for_user', [ReservationController::class, 'edit_for_user'])->name('reservation.edit_for_user');
        Route::get('/reservations_history', [ReservationController::class, 'show_history'])->name('reservation.show_history');
        Route::resource('/reservation', ReservationController::class)->only(['create','store','my_reservations','edit_for_user', 'update_for_user' ,'cancel']);
        Route::get('/user', function(){return view('user.user_home');})->name('user');
        Route::get('/reservations/available', [ReservationController::class, 'show_available'])->name('reservation.show_available');
        Route::get('/reservations/user_approved', [ReservationController::class, 'user_approved'])->name('reservation.user_approved');
        Route::get('/reservations/modal_closed', [ReservationController::class, 'modalClosed'])->name('reservation.modal_closed');
        Route::put('/reservation/{id}/update', [ReservationController::class, 'reservation_update_user'])->name('reservation.reservation_update_user');
        Route::get('/reservations_detail/{id}', [ReservationController::class, 'show_details'])->name('reservation.show_details');
        Route::get('/reservations/user_cancelled', [ReservationController::class, 'show_user_cancelled'])->name('reservation.show_user_cancelled');
        
    });

    Route::middleware([RestrictUserAccess::class])->group(function () {
        Route::resource('/reservation', ReservationController::class)->only(['edit','update','approved','index', 'show_cancelled','complete']);
        Route::get('/reservations/approved', [ReservationController::class, 'approved'])->name('reservation.approved');
        Route::get('/reservations/cancelled', [ReservationController::class, 'show_cancelled'])->name('reservation.show_cancelled');
        Route::get('/reservations/completed', [ReservationController::class, 'show_completed'])->name('reservation.show_completed');
        Route::get('/reservations/search', [ReservationController::class, 'search'])->name('completed.reservations.search');
        Route::get('/reservations/export', [ReservationController::class, 'exportCompletedTravels'])->name('completed.reservations.export');
        Route::put('/reservations/{reservation}/complete', [ReservationController::class, 'complete'])->name('reservations.complete');
        Route::delete('/reservations/{reservation}/delete', [ReservationController::class, 'destroy'])->name('reservations.destroy');
        Route::get('/administrator', function () {return view('administrator.admin_home');})->name('administrator');
        Route::resource('/drivers_inventory', DriverController::class);
        Route::resource('/cars_inventory', CarController::class);
        Route::get('/reservations_detail_admin/{id}', [ReservationController::class, 'show_details_admin'])->name('reservation.show_details_admin');
        Route::put('reservation/{reservation}/travel-status-update', [ReservationController::class, 'travelStatusUpdate'])->name('reservation.travel_status_update');

    });
});

});

require __DIR__.'/auth.php';

