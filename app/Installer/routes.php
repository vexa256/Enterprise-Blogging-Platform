<?php

Route::group(
    ['middleware' => ['web'], 'prefix' => 'Installer/install', 'namespace' => 'App\Installer\Controllers'],
    function () {
        Route::get('welcome', ['as' => 'installer::welcome',  'uses' => 'HomeController@index']);
        Route::get('permissions',  ['as' => 'installer::permissions',  'uses' => 'PermissionsController@index']);
        Route::get('database',   ['as' => 'installer::database',   'uses' => 'DatabaseController@index']);
        Route::post('database',  ['as' => 'installer::database',   'uses' => 'DatabaseController@post']);
        Route::get('database-finish',  ['as' => 'installer::database_finish',   'uses' => 'DatabaseController@finish']);

        Route::get('update',  ['as' => 'installer::update', 'uses' => 'DatabaseController@update']);
        Route::get('update_init',  ['as' => 'installer::update_init', 'uses' => 'DatabaseController@update_init']);
    }
);
