<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\NewMessageController;
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

Route::namespace('Api')
  ->prefix('apartments')
  ->group(function(){
  Route::get('/', [PostController::class, 'index']);
  Route::get('/get-key', [PostController::class, 'getKey']);
});

Route::namespace('Api')
  ->prefix('search')
  ->group(function(){
    Route::post('/', [SearchController::class, 'advancedSearch']);

  });
Route::namespace('Api')
  ->prefix('message')
  ->group(function(){
    Route::post('/', [NewMessageController::class, 'index']);
});

// Route::get('/apartments/search', [SearchController::class, 'advancedSearch']);

