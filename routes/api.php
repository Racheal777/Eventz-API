<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('events', EventController::class)->middleware(['auth:api', 'role:admin']);

Route::get('events', [EventController::class, 'allEvents'])->name('events.allEvents');

Route::get('days', [EventController::class, 'daysEvent'])->name('events.daysEvent');

Route::get('admin', [EventController::class, 'byAdmin'])->name('admin')->middleware('auth:api');

//users route
Route::post('users/signup', [UserController::class, 'register'])->name('users.register');

Route::post('users/login', [UserController::class, 'login'])->name('users.login');
