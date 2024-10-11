<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1',
    'namespace' => 'Dev\ElasticsearchLaravel\Http\Controllers\API',
], function () {
    Route::group(
        [
            // 'middleware' => ['auth:api']
        ],
        function () {
            Route::get('search', [
                'uses' => 'SearchController@search',
            ]);
        }
    );
});
