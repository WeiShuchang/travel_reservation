<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectBasedOnRole;



Route::get('/', function () {
    return view('home/home');
})->name('home')->middleware(RedirectIfAuthenticated::class);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




// Administrator Routes
Route::middleware([RedirectBasedOnRole::class . ':admin'])->group(function () {
        //Administrator Routes
    Route::get('/administrator', function () {
        return view('administrator.admin_home');
    })->name('administrator');

        // Routes for viewing all drivers and adding a new driver
    Route::get('/drivers_inventory', [DriverController::class, 'index'])->name('driver_inventory');
    Route::get('/drivers/create', [DriverController::class, 'create'])->name('add_driver');
    Route::post('/store_drivers', [DriverController::class, 'store'])->name('store_driver');

    // Routes for editing and deleting a driver
    Route::get('/drivers/{driver_id}/edit', [DriverController::class, 'edit'])->name('edit_driver');
    Route::put('/drivers/{driver_id}', [DriverController::class, 'update'])->name('update_driver');
    Route::delete('/drivers/{driver_id}', [DriverController::class, 'destroy'])->name('delete_driver');
});

// User Routes
Route::middleware([RedirectBasedOnRole::class . ':user'])->group(function () {

    Route::get('/user', function(){
        return view('user.user_home');
    })->name('user');

});