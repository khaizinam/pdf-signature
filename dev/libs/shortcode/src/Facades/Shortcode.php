<?php

namespace Dev\Shortcode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dev\Shortcode\Shortcode register(string $key, string|null $name, string|null $description = null, $callback = null, string $previewImage = '')
 * @method static void remove(string $key)
 * @method static \Dev\Shortcode\Shortcode setPreviewImage(string $key, string $previewImage)
 * @method static \Dev\Shortcode\Shortcode enable()
 * @method static \Dev\Shortcode\Shortcode disable()
 * @method static \Illuminate\Support\HtmlString compile(string $value, bool $force = false)
 * @method static string|null strip(string|null $value)
 * @method static array getAll()
 * @method static void setAdminConfig(string $key, callable|array|string|null $html)
 * @method static void modifyAdminConfig(string $key, callable $callback)
 * @method static string generateShortcode(string $name, array $attributes = [], string|null $content = null, bool $lazy = false)
 * @method static \Dev\Shortcode\Compilers\ShortcodeCompiler getCompiler()
 * @method static \Dev\Shortcode\ShortcodeField fields()
 *
 * @see \Dev\Shortcode\Shortcode
 */
class Shortcode extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'shortcode';
    }
}
