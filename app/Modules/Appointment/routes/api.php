<?php

use App\Modules\Appointment\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);

    // Специальные роуты для записей
    Route::get('/masters/{master}/appointments', [AppointmentController::class, 'getByMaster']);
    Route::get('/clients/{client}/appointments', [AppointmentController::class, 'getByClient']);
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel']);
    Route::post('/appointments/{appointment}/complete', [AppointmentController::class, 'complete']);
});
