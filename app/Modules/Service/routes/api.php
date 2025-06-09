<?php

use App\Modules\Service\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

    // Роуты по специализациям
    Route::prefix("services")->group(function (): void {
        Route::get('/get-by-specialization-id/{specialization}', [ServiceController::class, 'getBySpecializationId']);
    });
});
