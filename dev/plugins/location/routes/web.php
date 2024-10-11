<?php

use Dev\Base\Facades\AdminHelper;
use Dev\Location\Http\Controllers\ExportLocationController;
use Dev\Location\Http\Controllers\ImportLocationController;
use Dev\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Dev\Location\Http\Controllers'], function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'countries', 'as' => 'country.'], function () {
            Route::resource('', 'CountryController')->parameters(['' => 'country']);

            Route::get('list', [
                'as' => 'list',
                'uses' => 'CountryController@getList',
                'permission' => 'country.index',
            ]);
        });

        Route::group(['prefix' => 'states', 'as' => 'state.'], function () {
            Route::resource('', 'StateController')->parameters(['' => 'state']);

            Route::get('list', [
                'as' => 'list',
                'uses' => 'StateController@getList',
                'permission' => 'state.index',
            ]);
        });

        Route::group(['prefix' => 'cities', 'as' => 'city.'], function () {
            Route::resource('', 'CityController')->parameters(['' => 'city']);

            Route::get('list', [
                'as' => 'list',
                'uses' => 'CityController@getList',
                'permission' => 'city.index',
            ]);
        });

        Route::group(['prefix' => 'locations/bulk-import', 'as' => 'location.bulk-import.', 'permission' => 'location.bulk-import.index'], function () {
            Route::get('/', [ImportLocationController::class, 'index'])->name('index');
            Route::post('/', [ImportLocationController::class, 'import'])->name('store');
            Route::post('validate', [ImportLocationController::class, 'validateData'])->name('validate');
            Route::post('download-example', [ImportLocationController::class, 'downloadExample'])->name('download-example');
            Route::post('import-location-data', [ImportLocationController::class, 'importLocationData'])->name('import-location-data');
        });

        Route::group(['prefix' => 'locations/export', 'as' => 'location.export.', 'permission' => 'location.export.index'], function () {
            Route::get('/', [ExportLocationController::class, 'index'])->name('index');
            Route::post('/', [ExportLocationController::class, 'store'])->name('process');
        });
    });

    Theme::registerRoutes(function () {
        Route::get('ajax/states-by-country', 'StateController@ajaxGetStates')
            ->name('ajax.states-by-country');
        Route::get('ajax/cities-by-state', 'CityController@ajaxGetCities')
            ->name('ajax.cities-by-state');
    });
});
