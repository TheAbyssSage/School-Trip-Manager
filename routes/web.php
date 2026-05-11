<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'trips');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('trips', [TripController::class, 'index'])->name('trips.index');
    Route::get('trips/{trip}', [TripController::class, 'show'])->name('trips.show');

    Route::middleware('teacher')->group(function () {
        Route::get('trips/create', [TripController::class, 'create'])->name('trips.create');
        Route::post('trips', [TripController::class, 'store'])->name('trips.store');
        Route::get('trips/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
        Route::put('trips/{trip}', [TripController::class, 'update'])->name('trips.update');
        Route::delete('trips/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');

        Route::post('trips/{trip}/students/{student}/permission', [TripController::class, 'togglePermission'])
            ->name('trips.students.toggle-permission');
        Route::post('trips/{trip}/students/{student}/paid', [TripController::class, 'togglePaid'])
            ->name('trips.students.toggle-paid');
        Route::post('trips/{trip}/students/{student}/notes', [TripController::class, 'updateNotes'])
            ->name('trips.students.notes');
    });

    Route::get('/my-children', [ParentController::class, 'index'])->name('parent.children');
    Route::post('/my-children/{student}/trip/{trip}/submit-permission', [ParentController::class, 'submitPermission'])
        ->name('parent.submit-permission');
});
