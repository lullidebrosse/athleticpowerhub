<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseLogController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Exercise routes
    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
    
    // Exercise Log routes
    Route::get('/exercises/{exercise}/log', [ExerciseLogController::class, 'create'])->name('exercise-logs.create');
    Route::post('/exercises/{exercise}/log', [ExerciseLogController::class, 'store'])->name('exercise-logs.store');
    Route::get('/exercise-logs', [ExerciseLogController::class, 'index'])->name('exercise-logs.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
