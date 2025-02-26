<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;

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
Route::post('/authorization', [UserController::class, 'authorization']);
Route::post('/registration', [UserController::class, 'registration']);
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('/api-travel')->middleware('auth:sanctum')->group(function () {
    Route::get('/events', [EventController::class, 'show']);
    Route::get('/events/{{%id}}', [EventController::class, 'show']);
    Route::post('/events', [EventController::class, 'store']);
    Route::patch('/events/{{%id}}', [EventController::class, 'patchEvent']);
    Route::delete('/events/{{%id}}', [EventController::class, 'delete']);
    Route::delete('/events/{{%id}}/response', [EventController::class, 'storeResponse']);
    Route::post('/book-event', [EventController::class, 'storeBookEvent']);
    Route::get('/search', [EventController::class, 'search']);
    Route::get('/users/{{%id}}', [UserController::class, 'show']);
    Route::patch('/users/{{%id}}', [UserController::class, 'patchUser']);
    Route::post('/users/{{%id}}', [UserController::class, 'addPeople']);
});
