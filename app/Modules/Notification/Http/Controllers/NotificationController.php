<?php

namespace App\Modules\Notification\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Notification::welcome");
    }
}
