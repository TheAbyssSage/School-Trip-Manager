<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentTripController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('trips.index');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::resource('trips', TripController::class);

    // Pivot toggle routes
    Route::post('trips/{trip}/students/{student}/toggle-permission', [StudentTripController::class, 'togglePermission'])
        ->name('trips.students.toggle-permission');

    Route::post('trips/{trip}/students/{student}/toggle-paid', [StudentTripController::class, 'togglePaid'])
        ->name('trips.students.toggle-paid');

    Route::post('trips/{trip}/students/{student}/notes', [StudentTripController::class, 'updateNotes'])
        ->name('trips.students.notes');
});
