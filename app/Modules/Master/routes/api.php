<?php

use App\Modules\Master\Http\Controllers\MasterController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/masters', [MasterController::class, 'index']);
    Route::post('/masters', [MasterController::class, 'store']);
    Route::get('/masters/{master}', [MasterController::class, 'show']);
    Route::put('/masters/{master}', [MasterController::class, 'update']);
    Route::delete('/masters/{master}', [MasterController::class, 'destroy']);

    // Дополнительные роуты для мастеров
    Route::get('/masters/{master}/schedule', [MasterController::class, 'getSchedule']);
    Route::post('/masters/{master}/schedule', [MasterController::class, 'updateSchedule']);
});
