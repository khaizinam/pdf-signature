<?php

namespace Dev\AdvancedRole\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Laravel\Sanctum\Sanctum;

use Dev\Base\Supports\Helper;
use Dev\Kernel\Traits\LoadAndPublishDataTrait;
use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\AdvancedRole\Models\Member;
use Dev\Setting\PanelSections\SettingCommonPanelSection;
use Dev\AdvancedRole\Repositories\Eloquent\PermissionRepository;
use Dev\AdvancedRole\Repositories\Eloquent\RoleRepository;
use Dev\AdvancedRole\Repositories\Eloquent\TeamRepository;
use Dev\AdvancedRole\Repositories\Interfaces\PermissionInterface;
use Dev\AdvancedRole\Repositories\Interfaces\RoleInterface;
use Dev\AdvancedRole\Repositories\Interfaces\TeamInterface;
use Dev\AdvancedRole\Models\Permission;
use Dev\AdvancedRole\Models\Role;
use Dev\AdvancedRole\Models\Team;
use Dev\AdvancedRole\Observers\MemberObserver;
use Dev\AdvancedRole\Observers\RoleObserver;
use Dev\AdvancedRole\Observers\TeamObserver;
use Dev\AdvancedRole\Facades\AdvancedRoleHelper;
use Dev\Api\Http\Middleware\ForceJsonResponseMiddleware;
use Dev\AdvancedRole\Models\Scope;
use Dev\AdvancedRole\Repositories\Eloquent\ScopeRepository;
use Dev\AdvancedRole\Repositories\Interfaces\ScopeInterface;
use Dev\AdvancedRole\Models\PersonalAccessToken;
use Dev\AdvancedRole\Models\PermissionRole;
use Dev\AdvancedRole\Http\Middleware\AdvancedRoleMiddleware;

class AdvancedRoleServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app['config']->set([
            'scribe.routes.0.match.prefixes' => ['api/*'],
            'scribe.routes.0.apply.headers' => [
                'Authorization' => 'Bearer {token}',
                'Api-Version' => 'v1',
            ],
        ]);

        if (class_exists('AdvancedRoleHelper')) {
            AliasLoader::getInstance()->alias('AdvancedRoleHelper', AdvancedRoleHelper::class);
        }

        $this->app->bind(TeamInterface::class, function () {
            return new TeamRepository(new Team());
        });

        $this->app->bind(RoleInterface::class, function () {
            return new RoleRepository(new Role());
        });

        $this->app->bind(PermissionInterface::class, function () {
            return new PermissionRepository(new Permission());
        });

        $this->app->bind(ScopeInterface::class, function () {
            return new ScopeRepository(new Scope());
        });

        $this->registerMiddlewares();

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot(): void
    {
        $this
            ->setNamespace('libs/advanced-role')
            ->loadRoutes(['web', 'api'])
            ->loadAndPublishConfigurations([
                'advanced-role',
                'permissions',
                'permissions-seeds',
                'laratrust_seeder'
            ])
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->loadAndPublishViews();

        $this->app->register(CommandServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        /**
         * Laratrust comes with an events system that works like the Laravel model events. 
         * The events that you can listen to are roleAdded, roleRemoved, permissionAdded, permissionRemoved, roleSynced, permissionSynced.
         */
        Member::laratrustObserve(MemberObserver::class); // User Events
        Role::laratrustObserve(RoleObserver::class); // Role Events

        /**
         * Register any authentication / authorization services.
         */
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        if (AdvancedRoleHelper::enabled()) {
            $this->loadRoutes(['api']);
        }

        #region Dynamic configure for Laratrust
        Config::set('laratrust.user_models.users', Member::class);
        Config::set('laratrust.models', [
            'role' => Role::class,
            'permission' => Permission::class,
            'team' => Team::class, // Will be used only if the teams functionality is enabled.
        ]);
        Config::set('laratrust.tables', [
            'roles' => 'app_roles',
            'permissions' => 'app_permissions',
            'teams' => 'app_teams', // Will be used only if the teams functionality is enabled.
            'role_user' => 'app__role_members',
            'permission_user' => 'app__permission_members',
            'permission_role' => 'app__permission_roles',
        ]);
        #endregion

        $this->app['events']->listen(RouteMatched::class, function () {
            if (version_compare('7.0.0', get_core_version(), '>=')) {
                DashboardMenu::registerItem([
                    'id' => 'cms-libs-advanced-role',
                    'priority' => 9999,
                    'parent_id' => 'cms-core-settings',
                    'name' => 'libs/advanced-role::advanced-role.settings',
                    'icon' => null,
                    'url' => route('advanced-role.settings'),
                    'permissions' => ['advanced-role.settings'],
                ]);
            } else {
                PanelSectionManager::default()
                    ->registerItem(
                        SettingCommonPanelSection::class,
                        fn() => PanelSectionItem::make('settings.common.advanced-role')
                            ->setTitle(trans('libs/advanced-role::advanced-role.settings'))
                            ->withDescription(trans('libs/advanced-role::advanced-role.settings_description'))
                            ->withIcon('ti ti-users-group')
                            ->withPriority(110)
                            ->withRoute('advanced-role.settings')
                    );
            }
        });

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
    /**
     * Register the middlewares automatically.
     *
     * @return void
     */
    protected function registerMiddlewares()
    {
        $router = $this->app['router'];

        if (method_exists($router, 'middleware')) {
            $registerMethod = 'middleware';
        } elseif (method_exists($router, 'aliasMiddleware')) {
            $registerMethod = 'aliasMiddleware';
        } else {
            return;
        }

        $middlewares = [
            'advanced-role' => AdvancedRoleMiddleware::class // $router->aliasMiddleware('advanced-role', ActivityLogApiSecret::class);
        ];

        foreach ($middlewares as $key => $class) {
            $router->$registerMethod($key, $class);
        }
    }
}
