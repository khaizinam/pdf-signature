<?php

use Dev\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Dev\CustomField\Http\Controllers'], function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'custom-fields', 'as' => 'custom-fields.'], function () {
            Route::resource('', 'CustomFieldController')->parameters(['' => 'custom-field']);

            Route::get('export/{id?}', [
                'as' => 'export',
                'uses' => 'CustomFieldController@getExport',
                'permission' => 'custom-fields.index',
            ]);

            Route::post('import', [
                'as' => 'import',
                'uses' => 'CustomFieldController@postImport',
                'permission' => 'custom-fields.index',
            ]);
        });
    });
});
