<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConferenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/all-conferences', function () {
        return view('conferences.all-conferences');
    })->name('all-conferences.index');

    Route::get('/my-conferences', function () {
        return view('conferences.my-conferences');
    })->name('my-conferences.index');

    Route::get('/conference-management', function () {
        return view('conferences.conference-management');
    })->name('conference-management.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(('auth'))->group(function () {
    Route::post('/conferences', [ConferenceController::class, 'create'])->name('conferences.create');
    Route::patch('/conferences/{id}', [ConferenceController::class, 'update'])->name('conferences.update');
    Route::delete('/conferences/{id}', [ConferenceController::class, 'cancel'])->name('conferences.cancel');
    Route::get('/conferences', [ConferenceController::class, 'getAll'])->name('conferences.getAll');
    Route::get('/conferences/{id}', [ConferenceController::class, 'getOne'])->name('conferences.getOne');
});

require __DIR__.'/auth.php';
