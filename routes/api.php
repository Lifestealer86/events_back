<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventPlaceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/api-travel/siberian-nature', [AboutController::class, 'about']);
Route::post('/registration', [UserController::class, 'registration']);
Route::post('/authorization', [UserController::class, 'authorization']);
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('/api-travel')->middleware('auth:sanctum')->group(function () {
    Route::get('/event-places', [EventPlaceController::class, 'show']);
    Route::post('/event-places', [EventPlaceController::class, 'store']);
    Route::delete('/event-places/{id}', [EventPlaceController::class, 'delete']);
    Route::get('/events', [EventController::class, 'show']);
    Route::get('/events/{id}', [EventController::class, 'showOne']);
    Route::post('/events', [EventController::class, 'store']);
    Route::patch('/events/{id}', [EventController::class, 'patchEvent']);
    Route::delete('/events/{id}', [EventController::class, 'delete']);
    Route::get('/search/{query}', [EventController::class, 'search'])->where('query', '.*'); // done
    Route::post('/book-event', [EventController::class, 'storeBookEvent']);
    Route::delete('/events/{id}/response', [EventController::class, 'storeResponse']);
    Route::get('/users/{id}', [UserController::class, 'showData']);
    Route::patch('/users/{id}', [UserController::class, 'patchUser']);
    Route::post('/users/{id}', [UserController::class, 'addPeoples']);
});

Route::fallback(function () {
    return response()->json(["message" => "Not Found", "code" => 404], 404);
});
