<?php

use Dev\Shortcode\View\View;
use Dev\Theme\Theme;

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these events can be overridden by package config.
    |
    */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function ($theme): void {
            // You can remove this line anytime.
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function (Theme $theme): void {
            // Partial composer.
            // $theme->partialComposer('header', function($view) {
            //     $view->with('auth', \Auth::user());
            // });

            // You may use this event to set up your assets.

            $version = get_cms_version();

            $theme->asset()->usePath()->add('style', 'css/style.css',[],[], time());
            // $theme->asset()->container('header')->add('jquery_js', '//code.jquery.com/jquery-3.7.1.min.js');
            $theme->asset()->container('header')->usePath()->add('jquery','libraries/jquery.js');
            $theme->asset()->container('footer')->usePath()->add('jquery','libraries/app.js');
            $theme->asset()->container('header')->usePath()->add('signaturepad','libraries/signature_pad.umd.min.js');
            $theme->asset()->container('footer')->usePath()->add('script','js/script.js',[],[], time());

            if (function_exists('shortcode')) {
                $theme->composer(['page'], function (View $view) {
                    $view->withShortcodes();
                });
            }
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [
            'default' => function ($theme): void {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            },
        ],
    ],
];
