<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConferenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/conference-management', [ConferenceController::class, 'manage'])->name('conference-management.index');
    Route::get('/conferences/{conference}', [ConferenceController::class, 'getOne'])->name('conferences.getOne');
    Route::post('/conferences', [ConferenceController::class, 'create'])->name('conferences.create');
    Route::patch('/conferences/{conference}', [ConferenceController::class, 'update'])->name('conferences.update');
    Route::patch('/conferences/{conference}/cancel', [ConferenceController::class, 'cancel'])->name('conferences.cancel');

    Route::get('/all-conferences', [ConferenceController::class, 'getAll'])->name('all-conferences.index');
    Route::get('/my-conferences', [ConferenceController::class, 'getMyConferences'])->name('my-conferences.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
