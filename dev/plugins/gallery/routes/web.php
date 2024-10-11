<?php

use Dev\Base\Facades\AdminHelper;
use Dev\Gallery\Models\Gallery;
use Dev\Slug\Facades\SlugHelper;
use Dev\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Dev\Gallery\Http\Controllers'], function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'galleries', 'as' => 'galleries.'], function () {
            Route::resource('', 'GalleryController')->parameters(['' => 'gallery']);
        });
    });

    if (defined('THEME_MODULE_SCREEN_NAME')) {
        Theme::registerRoutes(function () {
            if (! theme_option('galleries_page_id')) {
                $prefix = SlugHelper::getPrefix(Gallery::class, 'galleries');

                Route::get($prefix ?: 'galleries', [
                    'as' => 'public.galleries',
                    'uses' => 'PublicController@getGalleries',
                ]);
            }
        });
    }
});
