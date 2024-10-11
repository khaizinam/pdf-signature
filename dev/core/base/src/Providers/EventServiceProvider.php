<?php

namespace Dev\Base\Providers;

use App\Http\Middleware\VerifyCsrfToken;
use Dev\ACL\Events\RoleAssignmentEvent;
use Dev\ACL\Events\RoleUpdateEvent;
use Dev\Base\Events\AdminNotificationEvent;
use Dev\Base\Events\BeforeEditContentEvent;
use Dev\Base\Events\CreatedContentEvent;
use Dev\Base\Events\DeletedContentEvent;
use Dev\Base\Events\PanelSectionsRendering;
use Dev\Base\Events\SendMailEvent;
use Dev\Base\Events\UpdatedContentEvent;
use Dev\Base\Events\UpdatedEvent;
use Dev\Base\Facades\AdminHelper;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Facades\MetaBox;
use Dev\Base\Http\Middleware\AdminLocaleMiddleware;
use Dev\Base\Http\Middleware\CoreMiddleware;
use Dev\Base\Http\Middleware\DisableInDemoModeMiddleware;
use Dev\Base\Http\Middleware\EnsureLicenseHasBeenActivated;
use Dev\Base\Http\Middleware\HttpsProtocolMiddleware;
use Dev\Base\Http\Middleware\LocaleMiddleware;
use Dev\Base\Listeners\AdminNotificationListener;
use Dev\Base\Listeners\BeforeEditContentListener;
use Dev\Base\Listeners\ClearDashboardMenuCaches;
use Dev\Base\Listeners\ClearDashboardMenuCachesForLoggedUser;
use Dev\Base\Listeners\CreatedContentListener;
use Dev\Base\Listeners\DeletedContentListener;
use Dev\Base\Listeners\PushDashboardMenuToSystemPanel;
use Dev\Base\Listeners\SendMailListener;
use Dev\Base\Listeners\UpdatedContentListener;
use Dev\Base\Models\AdminNotification;
use Dev\Support\Http\Middleware\BaseMiddleware;
use Illuminate\Auth\Events\Login;
use Illuminate\Config\Repository;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SendMailEvent::class => [
            SendMailListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
        BeforeEditContentEvent::class => [
            BeforeEditContentListener::class,
        ],
        AdminNotificationEvent::class => [
            AdminNotificationListener::class,
        ],
        UpdatedEvent::class => [
            ClearDashboardMenuCaches::class,
        ],
        Login::class => [
            ClearDashboardMenuCachesForLoggedUser::class,
        ],
        RoleAssignmentEvent::class => [
            ClearDashboardMenuCaches::class,
        ],
        RoleUpdateEvent::class => [
            ClearDashboardMenuCaches::class,
        ],
    ];

    public function boot(): void
    {
        $events = $this->app['events'];

        $events->listen(RouteMatched::class, function () {
            /**
             * @var Router $router
             */
            $router = $this->app['router'];

            $router->pushMiddlewareToGroup('web', LocaleMiddleware::class);
            $router->pushMiddlewareToGroup('web', AdminLocaleMiddleware::class);
            $router->pushMiddlewareToGroup('web', HttpsProtocolMiddleware::class);
            $router->aliasMiddleware('preventDemo', DisableInDemoModeMiddleware::class);
            $router->middlewareGroup('core', [CoreMiddleware::class]);

            $this->app->extend('core.middleware', function ($middleware) {
                return array_merge($middleware, [
                    EnsureLicenseHasBeenActivated::class,
                ]);
            });

            add_filter(BASE_FILTER_TOP_HEADER_LAYOUT, function ($options) {
                try {
                    $countNotificationUnread = AdminNotification::countUnread();
                } catch (Throwable) {
                    $countNotificationUnread = 0;
                }

                return $options . view('core/base::notification.nav-item', compact('countNotificationUnread'));
            }, 99);

            add_filter(BASE_FILTER_FOOTER_LAYOUT_TEMPLATE, function ($html) {
                if (! Auth::guard()->check()) {
                    return $html;
                }

                return $html . view('core/base::notification.notification');
            }, 99);

            add_action(BASE_ACTION_META_BOXES, [MetaBox::class, 'doMetaBoxes'], 8, 2);

            $this->disableCsrfProtection();
        });

        $events->listen(MigrationsStarted::class, function () {
            rescue(function () {
                if (DB::getDefaultConnection() === 'mysql') {
                    DB::statement('SET SESSION sql_require_primary_key=0');
                }
            }, report: false);
        });

        $events->listen(['cache:cleared'], function () {
            $files = $this->app['files'];

            $files->delete(storage_path('cache_keys.json'));

            $files->deleteDirectory(storage_path('app/chunks'));
            $files->deleteDirectory(storage_path('app/data-synchronize'));
            $files->deleteDirectory(storage_path('app/marketplace'));
        });

        $events->listen(PanelSectionsRendering::class, PushDashboardMenuToSystemPanel::class);

        if ($this->app->isLocal()) {
            DB::listen(function (QueryExecuted $queryExecuted) {
                if ($queryExecuted->time < 500) {
                    return;
                }

                Log::warning(sprintf('DB query exceeded %s ms. SQL: %s', $queryExecuted->time, $queryExecuted->sql));
            });
        }
    }

    protected function disableCsrfProtection(): void
    {
        /**
         * @var Repository $config
         */
        $config = $this->app['config'];

        if (
            BaseHelper::hasDemoModeEnabled()
            || $config->get('core.base.general.disable_verify_csrf_token', false)
            || ($this->app->environment('production') && AdminHelper::isInAdmin())
        ) {
            $this->app->instance(VerifyCsrfToken::class, new BaseMiddleware());
        }
    }
}
