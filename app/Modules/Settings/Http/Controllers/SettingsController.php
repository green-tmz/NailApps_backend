<?php

namespace App\Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Settings::welcome");
    }
}
