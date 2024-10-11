<?php

use Dev\Base\Facades\AdminHelper;
use Dev\Theme\Facades\Theme;
use Dev\Comment\Http\Controllers\CommentController;
use Dev\Comment\Http\Controllers\ReplyCommentController;
use Dev\Comment\Http\Controllers\Settings\CommentSettingController;
use Dev\Comment\Http\Controllers\Fronts\CommentController as FrontCommentController;
use Dev\Comment\Http\Controllers\Fronts\ReplyCommentController as FrontReplyCommentController;
use Illuminate\Support\Facades\Route;


Route::name('comment.')->group(function () {
    AdminHelper::registerRoutes(function () {
        Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
            Route::resource('', CommentController::class)->parameters(['' => 'comment']);
            Route::post('{comment}/reply', [ReplyCommentController::class, '__invoke'])->name('reply');
        });

        Route::group(['prefix' => 'settings', 'permission' => 'comment.settings'], function () {
            Route::get('comment', [CommentSettingController::class, 'edit'])->name('settings');
            Route::put('comment', [CommentSettingController::class, 'update'])->name('settings.update');
        });
    });

    Theme::registerRoutes(function () {
        Route::prefix('comment')->name('public.comments.')->group(function () {
            Route::get('comments', [FrontCommentController::class, 'index'])->name('index');
            Route::post('comments', [FrontCommentController::class, 'store'])->name('store');
            Route::post('comments/{comment}/reply', FrontReplyCommentController::class)->name('reply');
        });
    });
});
