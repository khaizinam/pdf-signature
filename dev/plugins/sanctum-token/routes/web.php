<?php

use Dev\Base\Facades\AdminHelper;
use Dev\SanctumToken\Http\Controllers\SanctumTokenController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::resource('sanctum-token', SanctumTokenController::class)
        ->except('edit', 'update', 'show');
});
