<?php

use Illuminate\Support\Facades\Route;
use Dev\Base\Facades\AdminHelper;

Route::group(['namespace' => 'Dev\ContractManagement\Http\Controllers'], function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'contract-managements', 'as' => 'contract-management.'], function () {
            Route::resource('', 'ContractManagementController')->parameters(['' => 'contract-management']);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'ContractManagementController@deletes',
                'permission' => 'contract-management.destroy',
            ]);
        });
    });
});
