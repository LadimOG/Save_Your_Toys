<?php

use App\Http\Controllers\ChildController;
use App\Http\Controllers\ToyController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('dashboard/Index');
    })->name('dashboard.index');
    Route::resource('toys', ToyController::class);
    Route::resource('children', ChildController::class);
});
