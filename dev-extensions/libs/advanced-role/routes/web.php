<?php

use Dev\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Dev\AdvancedRole\Http\Controllers',
    'middleware' => ['web', 'core'],
    'as' => 'advanced-role.'
], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'settings/advanced-role'], function () {
            Route::get('', [
                'as' => 'settings',
                'uses' => 'AdvancedRoleController@settings',
            ]);

            Route::post('', [
                'as' => 'settings.update',
                'uses' => 'AdvancedRoleController@storeSettings',
                'permission' => 'advanced-role.settings',
            ]);
        });
    });
});
