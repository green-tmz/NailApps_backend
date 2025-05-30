<?php

use App\Modules\Specialization\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\Route;

Route::get('/specializations', [SpecializationController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/specializations', [SpecializationController::class, 'store']);
    Route::get('/specializations/{specialization}', [SpecializationController::class, 'show']);
    Route::put('/specializations/{specialization}', [SpecializationController::class, 'update']);
    Route::delete('/specializations/{specialization}', [SpecializationController::class, 'destroy']);

    Route::get('/specializations/{specialization}/services', [SpecializationController::class, 'getServicesBySpecializationId']);
});
