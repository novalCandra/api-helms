<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HelmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, "login"]);
        Route::post('/register', [AuthController::class, "register"]);
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, "logout"]);
        });
    });


    Route::prefix('helments')->group(function () {
        Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
            Route::get('/', [HelmentController::class, "index"]);
            Route::get('/{id}', [HelmentController::class, "show"]);
            Route::post('/', [HelmentController::class, "store"]);
            Route::put('/{id}', [HelmentController::class, "update"]);
            Route::delete('/{id}', [HelmentController::class, "destroy"]);
        });
    });
});
