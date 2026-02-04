<?php

use App\Http\Controllers\ToyController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::resource('toys', ToyController::class);
