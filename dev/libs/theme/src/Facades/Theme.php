<?php

namespace Dev\Theme\Facades;

use Dev\Theme\Theme as BaseTheme;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dev\Theme\Theme layout(string $layout)
 * @method static \Dev\Theme\Theme uses(string|null $theme = null)
 * @method static \Dev\Theme\Theme theme(string|null $theme = null)
 * @method static bool hasInheritTheme()
 * @method static string|null getInheritTheme()
 * @method static bool exists(string|null $theme)
 * @method static string path(string|null $forceThemeName = null)
 * @method static mixed|null getConfig(string|null $key = null)
 * @method static mixed|null getInheritConfig(string|null $key = null)
 * @method static string getThemeNamespace(string $path = '')
 * @method static string getThemeName()
 * @method static \Dev\Theme\Theme setThemeName(string $theme)
 * @method static string getPublicThemeName()
 * @method static void fire(string $event, callable|object|array|string|null $args)
 * @method static \Dev\Theme\Breadcrumb breadcrumb()
 * @method static \Dev\Theme\Theme append(string $region, string $value)
 * @method static \Dev\Theme\Theme set(string $region, mixed|null $value)
 * @method static \Dev\Theme\Theme prepend(string $region, string $value)
 * @method static mixed bind(string $variable, callable|array|string|null $callback = null)
 * @method static bool binded(string $variable)
 * @method static mixed share(string $key, $value)
 * @method static string|null partialWithLayout(string $view, array $args = [])
 * @method static string getLayoutName()
 * @method static string|null partial(string $view, array $args = [])
 * @method static string|null loadPartial(string $view, string $partialDir, array $args)
 * @method static string|null watchPartial(string $view, array $args = [])
 * @method static void partialComposer(array|string $view, \Closure $callback, string|null $layout = null)
 * @method static void composer(array|string $view, \Closure $callback, string|null $layout = null)
 * @method static string|null place(string $region, string|null $default = null)
 * @method static mixed get(string $region, string|null $default = null)
 * @method static bool has(string $region)
 * @method static string|null content()
 * @method static \Dev\Theme\Asset|\Dev\Theme\AssetContainer asset()
 * @method static \Dev\Theme\Theme ofWithLayout(string $view, array $args = [])
 * @method static \Dev\Theme\Theme of(string $view, array $args = [])
 * @method static mixed scope(string $view, array $args = [], $default = null)
 * @method static \Dev\Theme\Theme setUpContent(string $view, array $args = [])
 * @method static \Dev\Theme\Theme load(string $view, array $args = [])
 * @method static array getContentArguments()
 * @method static mixed getContentArgument(string $key, $default = null)
 * @method static bool hasContentArgument(string $key)
 * @method static string|null location(bool $realPath = false)
 * @method static \Illuminate\Http\Response render(int $statusCode = 200)
 * @method static string header()
 * @method static string footer()
 * @method static void routes()
 * @method static \Illuminate\Routing\Router registerRoutes(\Closure|callable $closure)
 * @method static string loadView(string $view)
 * @method static string getStyleIntegrationPath()
 * @method static \Dev\Theme\Theme fireEventGlobalAssets()
 * @method static string getThemeScreenshot(string $theme)
 * @method static void registerThemeIconFields(array $icons, array $css = [], array $js = [])
 * @method static void registerFacebookIntegration()
 * @method static void registerSocialLinks()
 * @method static array getSocialLinksRepeaterFields()
 * @method static array getSocialLinks()
 * @method static array convertSocialLinksToArray(array|string|null $data)
 * @method static array getThemeIcons()
 * @method static static addBodyAttributes(array $bodyAttributes)
 * @method static string|null getBodyAttribute(string $attribute)
 * @method static array getBodyAttributes()
 * @method static string bodyAttributes()
 * @method static static addHtmlAttributes(array $htmlAttributes)
 * @method static string|null getHtmlAttribute(string $attribute)
 * @method static array getHtmlAttributes()
 * @method static string htmlAttributes()
 * @method static void registerPreloader()
 * @method static array getPreloaderVersions()
 * @method static void registerToastNotification()
 * @method static string|null getSiteCopyright()
 * @method static string|null getLogo(string $logoKey = 'logo')
 * @method static string|null getSiteTitle()
 * @method static \Illuminate\Support\HtmlString|null getLogoImage(array $attributes = [], string $logoKey = 'logo', int $maxHeight = 0, string|null $logoUrl = null)
 * @method static string|null formatDate(\Carbon\CarbonInterface|string|int|null $date, string|null $format = null)
 * @method static \Dev\Theme\Typography\Typography typography()
 * @method static string renderSocialSharing(string|null $url = null, string|null $title = null, string|null $thumbnail = null)
 *
 * @see \Dev\Theme\Theme
 */
class Theme extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseTheme::class;
    }
}
