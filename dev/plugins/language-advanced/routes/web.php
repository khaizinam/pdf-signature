<?php

use Dev\Base\Facades\AdminHelper;
use Dev\LanguageAdvanced\Http\Controllers\LanguageAdvancedController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group([
        'controller' => LanguageAdvancedController::class,
        'prefix' => 'language-advanced',
    ], function () {
        Route::post('save/{id}', [
            'as' => 'language-advanced.save',
            'uses' => 'save',
            'permission' => false,
        ])->wherePrimaryKey();
    });
});
