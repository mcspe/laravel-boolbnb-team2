<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->prefix('apartments')->group(function(){
  Route::get('/', [PostController::class, 'index']);
  Route::post('/search', [PostController::class, 'advancedSearch']);
});

// Route::get('/apartments/search', [PostController::class, 'advancedSearch']);

