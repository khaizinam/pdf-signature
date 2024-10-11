<?php

use Illuminate\Support\Facades\Route;

// Route::group([
//     'namespace' => 'Dev\Kernel\Http\Controllers\API\v1'
// ], function (Router $router) {
//     Route::group([], function () {
//     });

//     $router->get('documentation', [
//         'as' => 'l5-swagger.api',
//         'middleware' => config('l5-swagger.routes.middleware.api', []),
//         'uses' => 'KernelController@api',
//     ]);
//     $router->get(config('l5-swagger.routes.docs') . '/asset/{asset}', [
//         'as' => 'l5-swagger.asset',
//         'uses' => 'KernelController@asset',
//     ]);

//     Route::group([
//         'middleware' => [
//             'auth:api'
//         ]
//     ], function () {
//     });
// });

Route::group([
    'middleware' => [
        'app.middleware.empty-to-null',
        'api'
    ],
    'prefix' => 'api/v1',
    'namespace' => 'Dev\Kernel\Http\Controllers\API\v1',
], function () {
    Route::group(
        [
            // 'middleware' => ['auth:api']
        ],
        function () {
            Route::get('test', [
                'uses' => 'KernelController@test',
            ]);
        }
    );
});
