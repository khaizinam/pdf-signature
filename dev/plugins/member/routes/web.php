<?php

use Dev\Base\Facades\AdminHelper;
use Dev\Member\Models\Member;
use Dev\Slug\Facades\SlugHelper;
use Dev\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Dev\Member\Http\Controllers',
], function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'members', 'as' => 'member.'], function () {
            Route::resource('', 'MemberController')->parameters(['' => 'member']);
        });

        Route::group(['prefix' => 'settings', 'as' => 'member.'], function () {
            Route::get('members', [
                'as' => 'settings',
                'uses' => 'Settings\MemberSettingController@edit',
            ]);

            Route::put('members', [
                'as' => 'settings.update',
                'uses' => 'Settings\MemberSettingController@update',
                'permission' => 'member.settings',
            ]);
        });
    });

    if (defined('THEME_MODULE_SCREEN_NAME')) {
        Theme::registerRoutes(function () {
            Route::get(SlugHelper::getPrefix(Member::class, 'author') . '/{slug}')
                ->uses('PublicController@getAuthor')
                ->name('author.show');
        });
    }
});
