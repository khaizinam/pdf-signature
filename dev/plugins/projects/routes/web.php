<?php

use Illuminate\Support\Facades\Route;
use Dev\Base\Facades\AdminHelper;

Route::group(['namespace' => 'Dev\Projects\Http\Controllers'], function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'projects', 'as' => 'projects.'], function () {
            Route::resource('', 'ProjectsController')->parameters(['' => 'projects']);
        });
    });
});
