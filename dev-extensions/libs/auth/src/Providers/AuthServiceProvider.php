<?php

namespace Dev\Auth\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Dev\Auth\Facades\AuthHelper;
use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Setting\PanelSections\SettingCommonPanelSection;
use Dev\Kernel\Traits\LoadAndPublishDataTrait;
use Dev\AdvancedRole\Models\Member;

use Dev\Api\Http\Middleware\ForceJsonResponseMiddleware;
use Dev\Auth\Http\Middleware\RedirectIfMember;
use Dev\Auth\Http\Middleware\RedirectIfNotMember;

use ReflectionClass;

class AuthServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        if (class_exists('AuthHelper')) {
            AliasLoader::getInstance()->alias('AuthHelper', AuthHelper::class);
        }

        // Override, can be?
        // $this->app->bind(\Dev\Member\Repositories\Interfaces\MemberInterface::class, function () {
        //     return new \Dev\Member\Repositories\Eloquent\MemberRepository(new Member());
        // });

        // Override controller!
        // $this->app->bind(\Dev\Api\Http\Controllers\AuthenticationController::class, \Dev\Auth\Http\Controllers\API\v1\AuthController::class);
    }

    public function boot(): void
    {
        $this
            ->setNamespace('libs/auth')
            ->loadRoutes()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->loadAndPublishViews();

        if (AuthHelper::enabled()) {
            $this->loadRoutes(['api']);
        }
        $this->app['events']->listen(RouteMatched::class, function () {
            if (version_compare('7.0.0', get_core_version(), '>=')) {
                DashboardMenu::registerItem([
                    'id' => 'cms-libs-auth',
                    'priority' => 9999,
                    'parent_id' => 'cms-core-settings',
                    'name' => 'libs/auth::auth.settings',
                    'icon' => null,
                    'url' => route('auth.settings'),
                    'permissions' => ['auth.settings'],
                ]);
            } else {
                PanelSectionManager::default()
                    ->registerItem(
                        SettingCommonPanelSection::class,
                        fn() => PanelSectionItem::make('settings.common.auth')
                            ->setTitle(trans('libs/auth::auth.settings'))
                            ->withDescription(trans('libs/auth::auth.settings_description'))
                            ->withIcon('ti ti-api')
                            ->withPriority(110)
                            ->withRoute('auth.settings')
                    );
            }
        });

        #region create new authentication guard
        if (class_exists('AuthHelper') && AuthHelper::enabled()) {
            config([
                'auth.guards.advanced-role' => [
                    'driver' => 'session',
                    'provider' => 'advanced-role',
                ],
                'auth.providers.advanced-role' => [
                    'driver' => 'eloquent',
                    'model' => Member::class,
                ],
                'auth.passwords.advanced-role' => [
                    'provider' => 'advanced-role',
                    'table' => 'member_password_resets',
                    'expire' => 60,
                    'throttle' => 60
                ],
            ]);
        }
        #endregion

        $this->app['router']->aliasMiddleware('advanced-role', RedirectIfNotMember::class);
        $this->app['router']->aliasMiddleware('advanced-role.guest', RedirectIfMember::class);

        $this->app->booted(function () {
            config([
                'scribe.routes.0.match.prefixes' => ['api/*'],
                'scribe.routes.0.apply.headers' => [
                    'Authorization' => 'Bearer {token}',
                    'Api-Version' => 'v1',
                ],
            ]);
        });
    }

    protected function getPath(string $path = null): string
    {
        return __DIR__ . '/../..' . ($path ? '/' . ltrim($path, '/') : '');
    }
}
