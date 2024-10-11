<?php

namespace Dev\Language\Providers;

use Dev\Base\Facades\Assets;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Language\Facades\Language;
use Dev\Language\Http\Middleware\LocaleSessionRedirect;
use Dev\Language\Http\Middleware\LocalizationRedirectFilter;
use Dev\Language\Http\Middleware\LocalizationRoutes;
use Dev\Language\Models\Language as LanguageModel;
use Dev\Language\Models\LanguageMeta;
use Dev\Language\Repositories\Eloquent\LanguageMetaRepository;
use Dev\Language\Repositories\Eloquent\LanguageRepository;
use Dev\Language\Repositories\Interfaces\LanguageInterface;
use Dev\Language\Repositories\Interfaces\LanguageMetaInterface;
use Dev\Setting\PanelSections\SettingCommonPanelSection;
use Dev\Theme\Facades\Theme;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Arr;

class LanguageServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(LanguageInterface::class, function () {
            return new LanguageRepository(new LanguageModel());
        });

        $this->app->bind(LanguageMetaInterface::class, function () {
            return new LanguageMetaRepository(new LanguageMeta());
        });

        AliasLoader::getInstance()->alias('Language', Language::class);

        $router = $this->app['router'];
        $router->aliasMiddleware('localize', LocalizationRoutes::class);
        $router->aliasMiddleware('localizationRedirect', LocalizationRedirectFilter::class);
        $router->aliasMiddleware('localeSessionRedirect', LocaleSessionRedirect::class);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/language')
            ->loadAndPublishConfigurations(['general'])
            ->setNamespace('plugins/language')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(CommandServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        if (is_plugin_active('language')) {
            add_filter(BASE_FILTER_GROUP_PUBLIC_ROUTE, [$this, 'addLanguageMiddlewareToPublicRoute'], 958);
        }

        if (! $this->app->runningInConsole() && is_plugin_active('language')) {
            PanelSectionManager::default()->beforeRendering(function () {
                PanelSectionManager::registerItem(
                    SettingCommonPanelSection::class,
                    fn () => PanelSectionItem::make('language')
                        ->setTitle(trans('plugins/language::language.name'))
                        ->withIcon('ti ti-language')
                        ->withDescription(trans('plugins/language::language.description'))
                        ->withPriority(100)
                        ->withRoute('languages.index')
                );
            });

            $this->app['events']->listen(RouteMatched::class, function () {
                Assets::addScriptsDirectly('vendor/core/plugins/language/js/language-global.js')
                    ->addStylesDirectly(['vendor/core/plugins/language/css/language.css']);
            });

            $this->app->booted(function () {
                if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
                    Language::registerModule(THEME_OPTIONS_MODULE_SCREEN_NAME);
                }

                if (defined('WIDGET_MANAGER_MODULE_SCREEN_NAME')) {
                    Language::registerModule(WIDGET_MANAGER_MODULE_SCREEN_NAME);
                }

                if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME') && ! $this->app->isDownForMaintenance()) {
                    Theme::asset()
                        ->usePath(false)
                        ->add(
                            'language-css',
                            asset('vendor/core/plugins/language/css/language-public.css'),
                            [],
                            [],
                            '2.2.0'
                        );

                    Theme::asset()
                        ->container('footer')
                        ->usePath(false)
                        ->add(
                            'language-public-js',
                            asset('vendor/core/plugins/language/js/language-public.js'),
                            ['jquery'],
                            [],
                            '2.2.0'
                        );
                }

                Language::initModelRelations();

                $this->app->register(HookServiceProvider::class);
            });

            Language::setRoutesCachePath();
        }
    }

    public function addLanguageMiddlewareToPublicRoute(array $data): array
    {
        $locale = Language::setLocale();

        if (
            ! isset($data['prefix']) &&
            (! is_in_admin() || ! Language::hideDefaultLocaleInURL() || $locale !== Language::getDefaultLocale())
        ) {
            $data['prefix'] = trim((string) $locale);
        }

        $data['middleware'] = array_merge(Arr::get($data, 'middleware', []), [
            'localeSessionRedirect',
            'localizationRedirect',
        ]);

        $data['middleware'] = array_unique($data['middleware']);

        return $data;
    }
}
