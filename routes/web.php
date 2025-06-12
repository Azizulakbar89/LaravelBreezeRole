<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Teacher\TimetableController;

Route::get('/', function () {
    return view('welcome');
});

// Default dashboard (for all authenticated users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin dashboard (only for admins)
Route::middleware(['auth', 'verified', 'role.admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

// Teacher timetable (only for teachers)
Route::middleware(['auth', 'verified', 'role.teacher'])->group(function () {
    Route::get('/teacher/timetable', [TimetableController::class, 'index'])
        ->name('teacher.timetable');
});

// Profile routes (for all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
