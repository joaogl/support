<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Support Package
    |--------------------------------------------------------------------------
    |
    | Please provide the configurations for this package.
    |
    */

    'support' => [
        'RE_CAP_SITE' => env('RE_CAP_SITE'),
        'RE_CAP_SECRET' => env('RE_CAP_SECRET'),
        'relations' => [
            'UsersTable' => 'User',
            'UsersColumn' => 'id',
        ],
        'Dates_Format' => 'd/m/Y',
        'DateTime_Format' => 'd/m/Y h:i',
        'Setting' => [
            'path'     => app_path() . '/storage/meta',
            'filename' => 'setting.json',
            'fallback' => true,
            'autoAlias'=> true,
        ]
    ],

];