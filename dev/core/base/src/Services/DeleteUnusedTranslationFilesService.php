<?php

namespace Dev\Base\Services;

use Dev\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\File;

class DeleteUnusedTranslationFilesService
{
    public function handle(): void
    {
        $themeLangPath = lang_path('vendor/ui');

        if (! defined('THEME_MODULE_SCREEN_NAME') && File::isDirectory($themeLangPath)) {
            File::deleteDirectory($themeLangPath);
        }

        if (File::isDirectory($themeLangPath)) {
            foreach (BaseHelper::scanFolder($themeLangPath) as $theme) {
                if (! File::isDirectory(theme_path($theme))) {
                    File::deleteDirectory($themeLangPath . '/' . $theme);
                }
            }
        }

        if (File::isDirectory(lang_path('vendor/libs'))) {
            foreach (File::directories(lang_path('vendor/libs')) as $package) {
                if (! File::isDirectory(package_path(File::basename($package)))) {
                    File::deleteDirectory($package);
                }
            }
        }

        if (File::isDirectory(lang_path('vendor/plugins'))) {
            foreach (File::directories(lang_path('vendor/plugins')) as $plugin) {
                if (! File::isDirectory(plugin_path(File::basename($plugin)))) {
                    File::deleteDirectory($plugin);
                }
            }
        }
    }
}
