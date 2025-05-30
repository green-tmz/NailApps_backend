<?php

use App\Modules\Material\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/materials', [MaterialController::class, 'index']);
    Route::post('/materials', [MaterialController::class, 'store']);
    Route::get('/materials/{material}', [MaterialController::class, 'show']);
    Route::put('/materials/{material}', [MaterialController::class, 'update']);
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy']);

    // Дополнительные роуты для материалов
    Route::post('/materials/{material}/consume', [MaterialController::class, 'consume']);
    Route::post('/materials/{material}/restock', [MaterialController::class, 'restock']);
    Route::get('/materials/low-stock', [MaterialController::class, 'getLowStock']);
});
