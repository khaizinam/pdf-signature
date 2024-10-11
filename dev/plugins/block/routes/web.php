<?php

use Dev\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Dev\Block\Http\Controllers'], function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'blocks', 'as' => 'block.'], function () {
            Route::resource('', 'BlockController')->parameters(['' => 'block']);
        });
    });
});
