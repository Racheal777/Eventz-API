<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\SubcriberController;
use App\Http\Controllers\SubscriberController;

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

//event route
Route::apiResource('events', EventController::class)->middleware('auth:api');

Route::get('events', [EventController::class, 'allEvents'])->name('events.allEvents');

Route::get('days', [EventController::class, 'daysEvent'])->name('events.daysEvent');

Route::get('weeklyEvents', [EventController::class, 'weeklyEvents'])->name('events.weeklyEvents');

Route::get('admin', [EventController::class, 'byAdmin'])->name('admin')->middleware('auth:api');

Route::get('bycategory', [EventController::class, 'eventsBaseOnCategory'])->name('bycategory');


//users route
Route::post('users/signup', [UserController::class, 'register'])->name('users.register');

Route::post('users/login', [UserController::class, 'login'])->name('users.login');

Route::get('user', [UserController::class, "getUser"])->name('user')->middleware('auth:api');

Route::get('user/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth:api');


//organizer route
Route::post('organizer/signup', [OrganizerController::class, 'created'])->name('organizer.created');


//newsletter subscription
Route::apiResource('newsletters', SubscriberController::class);


//favorite routes
Route::apiResource('favorite', FavoriteController::class)->middleware('auth:api');
