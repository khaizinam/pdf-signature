<?php

use Illuminate\Support\Facades\Route;
use Dev\AdvancedRole\Http\Controllers\API\v1\ScopeController;
use Dev\AdvancedRole\Http\Controllers\API\v1\PermissionController;
use Dev\AdvancedRole\Http\Controllers\API\v1\RoleController;
use Dev\AdvancedRole\Http\Controllers\API\v1\TeamController;
use Dev\AdvancedRole\Http\Controllers\API\v1\TestController;

Route::group([
    'prefix' => 'api/v1',
    'namespace' => 'Dev\AdvancedRole\Http\Controllers\API\v1',
    'middleware' => ['api'],
    'as' => 'apps.api.v1.'
], function () {
    // Route::post('register', [
    //     'as' => 'advanced-role.register',
    //     'uses' => 'AdvancedRoleController@register',
    // ]);
    Route::group([
        'prefix' => 'advanced-role',
        'as' => 'advanced-role.'
    ], function () {
        Route::group(['middleware' => ['auth:sanctum', 'auth:advanced-role']], function () {
            Route::delete('teams/deletes', [TeamController::class, 'deletes'])->name('teams.deletes');
            Route::apiResource('teams', TeamController::class);
            Route::get('teams/{id}', [TeamController::class, 'show'])->name('teams.show');

            Route::delete('roles/deletes', [RoleController::class, 'deletes'])->name('roles.deletes');
            Route::apiResource('roles', RoleController::class);
            Route::get('roles/{id}', [RoleController::class, 'show'])->name('roles.show');

            Route::apiResource('permissions', PermissionController::class);
            Route::get('permissions/{id}', [PermissionController::class, 'show'])->name('permissions.show');

            Route::apiResource('scopes', ScopeController::class);
            Route::get('scopes/{id}', [ScopeController::class, 'show'])->name('scopes.show');

            Route::get('test', [TestController::class, 'index'])->name('advanced-role.test.index');
        });

        Route::group(['middleware' => ['auth:advanced-role']], function () {
            // Route::get('logout', [
            //     'as' => 'advanced-role.logout',
            //     'uses' => 'AdvancedRoleController@logout',
            // ]);
        });
    });
});
