<?php

namespace Dev\ACL\Providers;

use Dev\ACL\Http\Middleware\Authenticate;
use Dev\ACL\Http\Middleware\RedirectIfAuthenticated;
use Dev\ACL\Models\Activation;
use Dev\ACL\Models\Role;
use Dev\ACL\Models\User;
use Dev\ACL\Repositories\Eloquent\ActivationRepository;
use Dev\ACL\Repositories\Eloquent\RoleRepository;
use Dev\ACL\Repositories\Eloquent\UserRepository;
use Dev\ACL\Repositories\Interfaces\ActivationInterface;
use Dev\ACL\Repositories\Interfaces\RoleInterface;
use Dev\ACL\Repositories\Interfaces\UserInterface;
use Dev\Base\Facades\BaseHelper;
use Dev\Base\Facades\EmailHandler;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\PanelSections\System\SystemPanelSection;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Media\Facades\AppMedia;
use Exception;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as IlluminateView;

class AclServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(UserInterface::class, function () {
            return new UserRepository(new User());
        });

        $this->app->bind(ActivationInterface::class, function () {
            return new ActivationRepository(new Activation());
        });

        $this->app->bind(RoleInterface::class, function () {
            return new RoleRepository(new Role());
        });
    }

    public function boot(): void
    {
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        $this->setNamespace('core/acl')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['general', 'permissions', 'email'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadRoutes()
            ->loadMigrations();

        $this->garbageCollect();

        $this->app['events']->listen(RouteMatched::class, function () {
            $router = $this->app['router'];

            $router->aliasMiddleware('auth', Authenticate::class);
            $router->aliasMiddleware('guest', RedirectIfAuthenticated::class);
        });

        $this->registerPanelSections();

        $this->app->booted(function () {
            config()->set(['auth.providers.users.model' => User::class]);

            EmailHandler::addTemplateSettings('acl', config('core.acl.email', []), 'core');

            $this->app->register(HookServiceProvider::class);

            View::composer('core/acl::layouts.guest', function (IlluminateView $view) {
                $view->with('backgroundUrl', $this->getLoginPageBackgroundUrl());
            });
        });
    }

    protected function registerPanelSections(): void
    {
        PanelSectionManager::group('system')
            ->beforeRendering(function () {
                PanelSectionManager::registerItems(
                    SystemPanelSection::class,
                    fn () => [
                        PanelSectionItem::make('users')
                            ->setTitle(trans('core/acl::users.users'))
                            ->withIcon('ti ti-users')
                            ->withDescription(trans('core/acl::users.users_description'))
                            ->withPriority(-9999)
                            ->withRoute('users.index'),
                        PanelSectionItem::make('roles')
                            ->setTitle(trans('core/acl::permissions.role_permission'))
                            ->withIcon('ti ti-users-group')
                            ->withDescription(trans('core/acl::permissions.role_permission_description'))
                            ->withPriority(-9980)
                            ->withRoute('roles.index'),
                    ]
                );
            });
    }

    protected function getLoginPageBackgroundUrl(): string
    {
        $default = url(Arr::random(config('core.acl.general.backgrounds', [])));

        $images = setting('login_screen_backgrounds', []);

        if (! $images) {
            return $default;
        }

        $images = is_array($images) ? $images : json_decode($images, true);

        $images = array_filter($images);

        if (empty($images)) {
            return $default;
        }

        $image = Arr::random($images);

        if (! $image) {
            return $default;
        }

        return AppMedia::getImageUrl($image);
    }

    /**
     * Garbage collect activations and reminders.
     */
    protected function garbageCollect(): void
    {
        $config = $this->app->make('config')->get('core.acl.general');

        $this->sweep($this->app->make(ActivationInterface::class), Arr::get($config, 'activations.lottery', [2, 100]));
    }

    protected function sweep(ActivationInterface $repository, array $lottery): void
    {
        if ($this->configHitsLottery($lottery)) {
            try {
                $repository->removeExpired();
            } catch (Exception $exception) {
                BaseHelper::logError($exception);
            }
        }
    }

    /**
     * Determine if the configuration odds hit the lottery.
     */
    protected function configHitsLottery(array $lottery): bool
    {
        return mt_rand(1, $lottery[1]) <= $lottery[0];
    }
}
