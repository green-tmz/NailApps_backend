<?php

use App\Modules\Schedule\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/schedules', [ScheduleController::class, 'index']);
    Route::post('/schedules', [ScheduleController::class, 'store']);
    Route::get('/schedules/{schedule}', [ScheduleController::class, 'show']);
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update']);
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy']);

    // Дополнительные роуты для расписания
    Route::get('/masters/{master}/schedules', [ScheduleController::class, 'getByMaster']);
    Route::get('/available-times', [ScheduleController::class, 'getAvailableTimes']);
});
