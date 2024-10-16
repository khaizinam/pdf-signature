<?php

use Dev\Base\Facades\AdminHelper;
use Dev\Turnstile\Http\Controllers\Settings\TurnstileSettingController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['permission' => 'turnstile.settings'], function () {
        Route::get('settings/turnstile', [TurnstileSettingController::class, 'edit'])
            ->name('turnstile.settings');

        Route::put('settings/turnstile', [TurnstileSettingController::class, 'update'])
            ->name('turnstile.settings.update');
    });
});
