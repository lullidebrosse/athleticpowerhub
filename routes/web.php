<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('exercises', ExerciseController::class);

        // Admin routes
        Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::resource('exercises', ExerciseController::class);
            Route::post('exercises/{exercise}/approve', [ExerciseController::class, 'approve'])->name('exercises.approve');
            Route::post('exercises/{exercise}/reject', [ExerciseController::class, 'reject'])->name('exercises.reject');
        });
});
