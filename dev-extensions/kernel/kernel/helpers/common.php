<?php

if (! function_exists('addons_path')) {
    /**
     * @return string
     */
    function addons_path(?string $path = null, ?string $platform_path = 'dev-extensions'): string
    {
        $path = ltrim($path, DIRECTORY_SEPARATOR);

        return base_path($platform_path . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }
}

if (! function_exists('addons_kernel_path')) {
    /**
     * @param string|null $path
     * @return string
     */
    function addons_kernel_path(?string $path = null): string
    {
        return addons_path('kernel' . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : ''));
    }
}

if (! function_exists('addons_package_path')) {
    /**
     * @param string|null $path
     * @return string
     */
    function addons_package_path(?string $path = null): string
    {
        return addons_path('libs' . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : ''));
    }
}

if (!function_exists('addons_plugins_path')) {
    /**
     * @param string|null $path
     * @return string
     */
    function addons_plugins_path($path = null): string
    {
        return addons_path('plugins' . DIRECTORY_SEPARATOR . $path);
    }
}
