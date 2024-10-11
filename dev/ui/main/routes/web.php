<?php

use Illuminate\Support\Facades\Route;
use Theme\Main\Http\Controllers\MainController;

// Custom routes
// You can delete this route group if you don't need to add your custom routes.
Route::group(['controller' => MainController::class, 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::get("/", 'getIndex')->name("public.index");
    });
});

// Theme::routes();
