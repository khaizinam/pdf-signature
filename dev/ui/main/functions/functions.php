<?php

use Dev\Media\Facades\RvMedia;
use Dev\Menu\Facades\Menu;
use Dev\Theme\Facades\Theme;
use Dev\Theme\Supports\ThemeSupport;
use Dev\Theme\Typography\TypographyItem;

register_page_template([
    'default' => __('Default'),
]);

app()->booted(function () {
    Menu::addMenuLocation('menu-header', 'Menu header');
    AppMedia::addSize('medium', 800, 800);

    ThemeSupport::registerSiteCopyright();

    Theme::typography()
        ->registerFontFamilies([
            new TypographyItem('primary', __('Primary'), 'Roboto'),
        ])
        ->registerFontSizes([
            new TypographyItem('h1', __('Heading 1'), 28),
            new TypographyItem('h2', __('Heading 2'), 24),
            new TypographyItem('h3', __('Heading 3'), 22),
            new TypographyItem('h4', __('Heading 4'), 20),
            new TypographyItem('h5', __('Heading 5'), 18),
            new TypographyItem('h6', __('Heading 6'), 16),
            new TypographyItem('body', __('Body'), 14),
        ]);
});
