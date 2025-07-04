<?php

/*
|--------------------------------------------------------------------------
| Auth Config
|--------------------------------------------------------------------------
|
| Keep in mind:
| All settings you define here have less priority than
| those in the 'specific' section of the config/modules.php file
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Module Status
    |--------------------------------------------------------------------------
    |
    | Here you can determine whether this module should be
    | disabled or enabled
    |
    | Supported: true, false
    |
    */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Type Of Routing
    |--------------------------------------------------------------------------
    |
    | If you need / don't need different route files for web and api
    | you can change the array entries like you need them.
    |
    | Supported: "web", "api", "simple"
    |
    */

    'routing' => ['web', 'api'],

    /*
    |--------------------------------------------------------------------------
    | Module Structure
    |--------------------------------------------------------------------------
    |
    | In case your desired module structure differs
    | from the default structure defined in config/modules.php
    | feel free to change it the way you like it,
    |
    */

    'structure' => [
        'controllers' => 'Http/Controllers',
        'resources' => 'Http/Resources',
        'requests' => 'Http/Requests',
        'models' => 'Models',
        'mails' => 'Mail',
        'notifications' => 'Notifications',
        'events' => 'Events',
        'listeners' => 'Listeners',
        'observers' => 'Observers',
        'jobs' => 'Jobs',
        'rules' => 'Rules',
        'views' => 'resources/views',
        'translations' => 'resources/lang',
        'routes' => 'routes',
        'migrations' => 'database/migrations',
        'seeds' => 'database/seeds',
        'factories' => 'database/factories',
        'helpers' => '',
    ],
];
