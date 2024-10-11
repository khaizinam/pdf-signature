<?php

use Dev\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Dev\Auth\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'settings/auth'], function () {
            Route::get('', [
                'as' => 'auth.settings',
                'uses' => 'AuthController@settings',
            ]);

            Route::post('', [
                'as' => 'auth.settings.update',
                'uses' => 'AuthController@storeSettings',
                'permission' => 'auth.settings',
            ]);
        });
    });
});
