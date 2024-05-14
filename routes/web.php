<?php

use App\Http\Controllers\Api\V1\Event\EventController;
use App\Http\Controllers\Api\V1\Room\RoomController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard/',[RoomController::class , 'index'])->name('dashboard');
    Route::get('room/{id}' , [RoomController::class , 'show'])->name('room.show');
    Route::post('event', [EventController::class , 'update'])->name('event.update');
    Route::post('reserve/room/{id}', [EventController::class , 'reserve'])->name('room.reserve');
    Route::post('room/update-price', [EventController::class , 'updatePrice'])->name('event.update.price');
});