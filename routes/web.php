<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\MetricController;
use App\Http\Controllers\PersonalRecordController;
use App\Http\Controllers\DashboardController;

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
});

Route::middleware(['auth'])->group(function () {
    // Exercise routes
    Route::get('exercises', [ExerciseController::class, 'index'])->name('exercises.index');
    Route::get('exercises/create', [ExerciseController::class, 'create'])->name('exercises.create');
    Route::post('exercises', [ExerciseController::class, 'store'])->name('exercises.store');
    
    // Metric routes
    Route::resource('metrics', MetricController::class);
    
    // Personal Record routes
    Route::get('personal-records', [PersonalRecordController::class, 'index'])->name('personal-records.index');
    Route::get('personal-records/{personalRecord}', [PersonalRecordController::class, 'show'])->name('personal-records.show');
    Route::delete('personal-records/{personalRecord}', [PersonalRecordController::class, 'destroy'])->name('personal-records.destroy');
    Route::get('personal-records/exercise/{exercise}', [PersonalRecordController::class, 'byExercise'])->name('personal-records.by-exercise');
    Route::get('personal-records/dashboard', [PersonalRecordController::class, 'dashboard'])->name('personal-records.dashboard');
    
    // Admin routes for managing exercises
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('exercises', ExerciseController::class);
        Route::post('exercises/{exercise}/approve', [ExerciseController::class, 'approve'])->name('exercises.approve');
        Route::post('exercises/{exercise}/reject', [ExerciseController::class, 'reject'])->name('exercises.reject');
    });
});
