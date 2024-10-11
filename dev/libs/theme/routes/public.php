<?php

use Dev\Slug\Facades\SlugHelper;
use Dev\Theme\Events\ThemeRoutingAfterEvent;
use Dev\Theme\Events\ThemeRoutingBeforeEvent;
use Dev\Theme\Facades\SiteMapManager;
use Dev\Theme\Facades\Theme;
use Dev\Theme\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Theme::registerRoutes(function () {
    Route::group(['controller' => PublicController::class], function () {
        event(new ThemeRoutingBeforeEvent(app()->make('router')));

        Route::get('/', 'getIndex')->name('public.index');

        Route::get('{key}.{extension}', 'getSiteMapIndex')
            ->where('key', '^' . collect(SiteMapManager::getKeys())->map(fn ($item) => '(?:' . $item . ')')->implode('|') . '$')
            ->whereIn('extension', SiteMapManager::allowedExtensions())
            ->name('public.sitemap.index');

        Route::get('{slug?}', 'getView')->name('public.single');

        Route::get('{prefix}/{slug?}', 'getViewWithPrefix')
            ->whereIn('prefix', SlugHelper::getAllPrefixes() ?: ['1437bcd2-d94e-4a5fd-9a39-b5d60225e9af']);

        event(new ThemeRoutingAfterEvent(app()->make('router')));
    });
});
