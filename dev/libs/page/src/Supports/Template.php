<?php

namespace Dev\Page\Supports;

use Dev\Base\Facades\BaseHelper;
use Dev\Theme\Facades\Theme;

class Template
{
    public static function registerPageTemplate(array $templates = []): void
    {
        $validTemplates = [];
        foreach ($templates as $key => $template) {
            if (in_array($key, self::getExistsTemplate())) {
                $validTemplates[$key] = $template;
            }
        }

        config([
            'libs.page.general.templates' => array_merge(
                config('libs.page.general.templates'),
                $validTemplates
            ),
        ]);
    }

    protected static function getExistsTemplate(): array
    {
        $themes = [
            Theme::getThemeName(),
        ];

        if (Theme::hasInheritTheme()) {
            $themes[] = Theme::getInheritTheme();
        }

        foreach ($themes as $theme) {
            $files = BaseHelper::scanFolder(theme_path($theme . DIRECTORY_SEPARATOR . config('libs.theme.general.containerDir.layout')));

            foreach ($files as $key => $file) {
                $files[$key] = str_replace('.blade.php', '', $file);
            }
        }

        return $files;
    }

    public static function getPageTemplates(): array
    {
        return (array) config('libs.page.general.templates', []);
    }
}
