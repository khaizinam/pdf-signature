<?php

declare(strict_types=1);

use Dev\Base\Facades\AdminHelper;
use Dev\EmailLog\Http\Controllers\EmailLogController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::prefix('email-logs')->name('email-logs.')->group(function () {
        Route::resource('', EmailLogController::class)
            ->only('index', 'edit', 'destroy')
            ->parameters(['' => 'email-log']);
    });
}, ['web', 'core', 'auth']);
