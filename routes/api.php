<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventPlaceController;
use App\Http\Controllers\FeedbacksController;
use App\Http\Controllers\BookEventController;
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

Route::get('/about', [AboutController::class, 'about']);
Route::post('/registration', [UserController::class, 'registration']);
Route::post('/authorization', [UserController::class, 'authorization']);
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/event-places', [EventPlaceController::class, 'show']);
    Route::post('/event-places', [EventPlaceController::class, 'store']);
    Route::delete('/event-places/{id}', [EventPlaceController::class, 'delete']);
    Route::get('/events', [EventController::class, 'show']);
    Route::get('/events/{id}', [EventController::class, 'showOne']);
    Route::post('/events', [EventController::class, 'store']);
    Route::patch('/events/{id}', [EventController::class, 'patchEvent']);
    Route::delete('/events/{id}', [EventController::class, 'delete']);
    Route::get('/search/{query}', [EventController::class, 'search'])->where('query', '.*');
    Route::get('/feedbacks/{event_id}', [FeedbacksController::class, 'showFeedbacks']);
    Route::post('/feedbacks/{event_id}', [FeedbacksController::class, 'storeFeedback']);
    Route::delete('/feedbacks/{event_id}', [FeedbacksController::class, 'deleteFeedback']);
    Route::get('/users/{id}', [UserController::class, 'showData']);
    Route::patch('/users/{id}', [UserController::class, 'patchUser']);
    Route::post('/users/peoples', [UserController::class, 'addPeoples']);
    Route::delete('/users/peoples/{id}', [UserController::class, 'deletePeople']); // done
    Route::get('/book-event', [BookEventController::class, 'showBookEvent']);
    Route::post('/book-event', [BookEventController::class, 'storeBookEvent']);
    Route::delete('/book-event/{event_id}', [BookEventController::class, 'deleteBookEvent']);
});

Route::fallback(function () {
    return response()->json(["message" => "Not Found", "code" => 404], 404);
});
