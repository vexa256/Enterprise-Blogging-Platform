<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Buzzy Theme Configuration
    |--------------------------------------------------------------------------
    */
    'version' => '3.0.3',
    'item_id' => 13300279,
    'item_code' => 'buzzy',

    /*
    |--------------------------------------------------------------------------
    | Buzzy Themes
    |--------------------------------------------------------------------------
    */
    "themes"  => [
        "modern" => [
            'version' => '3.0.0',
        ],
        "buzzyfeed" => [
            'version' => '3.0.0',
        ],
        "viralmag" => [
            'version' => '3.0.0',
        ],
        "boxed" => [
            'version' => '3.0.0',
        ],
        "default" => [
            'version' => '3.0.0',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Buzzy Plugins
    |--------------------------------------------------------------------------
    */
    "plugins"  => [
        "buzzynews" => [
            'version' => '3.0.0',
        ],
        "buzzylists" => [
            'version' => '3.0.0',
        ],
        "buzzyvideos" => [
            'version' => '3.0.0',
        ],
        "buzzypolls" => [
            'version' => '3.0.0',
        ],
        "facebookcomments" => [
            'version' => '1.0.0',
        ],
        "disquscomments" => [
            'version' => '1.0.0',
        ],
        "homepagebuilder" => [
            'version' => '1.0.0',
        ],
        "reactionform" => [
            'version' => '1.0.0',
        ],
        "translationmanager" => [
            'version' => '1.0.0',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Buzzy Post Types
    |--------------------------------------------------------------------------
    */
    "post_types" => [
        'news' => ['name' => 'news', 'icon' => 'file-text' , 'trans' => 'v3.story'],
        'list' => ['name' => 'List', 'icon' => 'sort-numeric-asc', 'trans' => 'index.list'],
        'quiz' => ['name' => 'Quiz', 'icon' => 'check-square-o', 'trans' => 'index.quiz'],
        'poll' => ['name' => 'Poll', 'icon' => 'check-circle-o', 'trans' => 'index.poll'],
        'video' => ['name' => 'Quiz', 'icon' => 'video-camera', 'trans' => 'index.video'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Last published version
    |--------------------------------------------------------------------------
    |
    | This is where you can specify the last version of your application
    | This is used to determine if the application requires an update
    | The current running version is stored in framework/installed
    |
    */
    'upgrade' => [
        'migrations' => '*',
        'seeds' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */
    'requirements' => [
        'openssl',
        'pdo',
        'gd',
        'zip',
        'mbstring',
        'fileinfo',
        'tokenizer'
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions' => [
        'public/upload/',
        'storage/app/',
        'storage/framework/',
        'storage/logs/',
        'bootstrap/cache/',
        '.env'
    ]
];
