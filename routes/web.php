<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalCarsController;
use App\Http\Controllers\ReturnCarsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('cars', CarController::class)->middleware(['auth','role:A']);
    Route::resource('rentals', RentalCarsController::class);
    Route::patch('rentals/status/{id}', [RentalCarsController::class, 'status'])->name('rentals.status');
    Route::resource('returns', ReturnCarsController::class);
});

require __DIR__.'/auth.php';
