<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'auth'], function() {
        require app_path('Modules/Auth/routes/api.php');
    });

    require app_path('Modules/Specialization/routes/api.php');
    require app_path('Modules/Appointment/routes/api.php');
    require app_path('Modules/Client/routes/api.php');
    require app_path('Modules/Master/routes/api.php');
    require app_path('Modules/Material/routes/api.php');
    require app_path('Modules/Notification/routes/api.php');
    require app_path('Modules/Service/routes/api.php');
});
