<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/logout-all', [AuthController::class, 'logoutAll']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
    Route::put('/auth/change-password', [AuthController::class, 'changePassword']);

    // Legacy route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Data Migration routes (Super Admin only)
    Route::prefix('data-migration')->middleware('role:super_admin')->group(function () {
        Route::get('/status', [App\Http\Controllers\Api\DataMigrationController::class, 'getStatus']);
        Route::post('/import', [App\Http\Controllers\Api\DataMigrationController::class, 'importNews']);
        Route::post('/import-all', [App\Http\Controllers\Api\DataMigrationController::class, 'importAll']);
        Route::post('/import-apbd', [App\Http\Controllers\Api\DataMigrationController::class, 'importApbd']);
        Route::post('/clear-data', [App\Http\Controllers\Api\DataMigrationController::class, 'clearData']);
    });
});

// Public API routes
Route::prefix('news')->group(function () {
    Route::get('/latest', [App\Http\Controllers\Api\NewsController::class, 'latest']);
    Route::get('/', [App\Http\Controllers\Api\NewsController::class, 'index']);
    Route::get('/{slug}', [App\Http\Controllers\Api\NewsController::class, 'show']);
});
