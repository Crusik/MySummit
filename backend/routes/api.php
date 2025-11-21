<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\LabResultController;

// Public authentication routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require Sanctum authentication)
Route::middleware(['auth.api:sanctum']) -> group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

    Route::get('/conversations', [ConversationController::class, 'index']);
    Route::get('/conversations/{id}', [ConversationController::class, 'show']);
    Route::post('/conversations', [ConversationController::class, 'store']);

    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{id}', [MessageController::class, 'show']);
    Route::post('/messages', [MessageController::class, 'store']);

    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::post('/events', [EventController::class, 'store']);

    Route::get('/payments', [PaymentController::class, 'index']);
    Route::get('/payments/{id}', [PaymentController::class, 'show']);
    Route::post('/payments', [PaymentController::class, 'store']);

    Route::get('/health', [HealthController::class, 'index']);
    Route::get('/health/{id}', [HealthController::class, 'show']);
    Route::post('/health', [HealthController::class, 'store']);

    Route::get('/lab-results', [LabResultController::class, 'index']);
    Route::get('/lab-results/{labResult}', [LabResultController::class, 'show']);
    Route::post('/lab-results', [LabResultController::class, 'store']);
    Route::put('/lab-results/{labResult}', [LabResultController::class, 'update']);
    Route::delete('/lab-results/{labResult}', [LabResultController::class, 'destroy']);
});