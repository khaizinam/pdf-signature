<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api/v1/auth',
    'namespace' => 'Dev\Auth\Http\Controllers\API\v1',
    'middleware' => ['api'],
    'as' => 'apps.api.v1.'
], function () {
    Route::post('register', [
        'as' => 'auth.register',
        'uses' => 'AuthController@register',
    ]);
    Route::post('login', [
        'as' => 'auth.login',
        'uses' => 'AuthController@login',
    ]);
    Route::post('password/forgot', [
        'as' => 'auth.password.forgot',
        'uses' => 'ForgotPasswordController@sendResetLinkEmail',
    ]);
    Route::post('resend-verify-account-email', [
        'as' => 'auth.resend-verify-account-email',
        'uses' => 'VerificationController@resend',
    ]);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('logout', [
            'as' => 'auth.logout',
            'uses' => 'AuthController@logout',
        ]);
        Route::get('me', [
            'as' => 'auth.me',
            'uses' => 'ProfileController@getProfile',
        ]);
        Route::put('me', [
            'as' => 'auth.me.put',
            'uses' => 'ProfileController@updateProfile',
        ]);
        Route::post('update/avatar', [
            'as' => 'auth.update.avatar',
            'uses' => 'ProfileController@updateAvatar',
        ]);
        Route::put('update/password', [
            'as' => 'auth.update.password',
            'uses' => 'ProfileController@updatePassword',
        ]);
    });
});
