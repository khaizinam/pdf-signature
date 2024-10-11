<?php

namespace Dev\Ticksify\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Ecommerce\Models\Customer;
use Dev\RealEstate\Models\Account;
use Dev\Ticksify\Models\Ticket;
use Illuminate\Foundation\Application;

class TicksifyServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/ticksify')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->registerDashboardMenu()
            ->loadAndPublishViews()
            ->resolveRelations()
            ->loadMigrations()
            ->publishAssets()
            ->loadRoutes();

        $this->app->booted(fn (Application $app) => $app->register(HookServiceProvider::class));
    }

    protected function registerDashboardMenu(): self
    {
        DashboardMenu::beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-ticksify',
                    'priority' => 999,
                    'name' => 'plugins/ticksify::ticksify.name',
                    'icon' => 'ti ti-ticket',
                    'permissions' => ['ticksify'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-ticksify-tickets',
                    'priority' => 10,
                    'parent_id' => 'cms-plugins-ticksify',
                    'name' => 'plugins/ticksify::ticksify.tickets.name',
                    'route' => 'ticksify.tickets.index',
                ])
                ->registerItem([
                    'id' => 'cms-plugins-ticksify-messages',
                    'priority' => 20,
                    'parent_id' => 'cms-plugins-ticksify',
                    'name' => 'plugins/ticksify::ticksify.messages.name',
                    'route' => 'ticksify.messages.index',
                ])
                ->registerItem([
                    'id' => 'cms-plugins-ticksify-categories',
                    'priority' => 20,
                    'parent_id' => 'cms-plugins-ticksify',
                    'name' => 'plugins/ticksify::ticksify.categories.name',
                    'route' => 'ticksify.categories.index',
                ]);
        });

        DashboardMenu::for(is_plugin_active('ecommerce') ? 'customer' : 'account')
            ->beforeRetrieving(function () {
                DashboardMenu::make()->registerItem([
                    'id' => 'cms-plugins-ticksify-public',
                    'priority' => 90,
                    'name' => __('Tickets'),
                    'url' => fn () => route('ticksify.public.tickets.index'),
                    'icon' => 'ti ti-ticket',
                ]);
            });

        return $this;
    }

    protected function resolveRelations(): self
    {
        if (is_plugin_active('ecommerce')) {
            Customer::resolveRelationUsing('tickets', function (Customer $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        if (is_plugin_active('real-estate')) {
            Account::resolveRelationUsing('tickets', function (Account $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        if (is_plugin_active('job-board')) {
            \Dev\JobBoard\Models\Account::resolveRelationUsing('tickets', function (\Dev\JobBoard\Models\Account $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        if (is_plugin_active('hotel')) {
            \Dev\Hotel\Models\Account::resolveRelationUsing('tickets', function (\Dev\Hotel\Models\Account $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        return $this;
    }
}
