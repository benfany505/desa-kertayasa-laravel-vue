<?php

use Illuminate\Support\Facades\Route;

// SPA Route - All routes handled by Vue Router
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
