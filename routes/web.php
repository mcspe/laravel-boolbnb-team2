<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





// rotte protette
Route::middleware(['auth','verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::resource('apartments', ApartmentController::class);
        Route::resource('sponsorships', SponsorshipController::class);
        Route::resource('messages', MessageController::class);
});


require __DIR__.'/auth.php';
