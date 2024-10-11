<?php

namespace Dev\ContractManagement\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Base\Facades\DashboardMenu;
use Dev\ContractManagement\Models\ContractManagement;
use Dev\ContractManagement\Repositories\Caches\ContractManagementCacheDecorator;
use Dev\ContractManagement\Repositories\Eloquent\ContractManagementRepository;
use Dev\ContractManagement\Repositories\Interfaces\ContractManagementInterface;
use Dev\Slug\Facades\SlugHelper;

class ContractManagementServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    public function register(): void
    {
        $this->app->bind(ContractManagementInterface::class, function () {
            return new ContractManagementCacheDecorator(new ContractManagementRepository(new ContractManagement()));
        });

        $this->setNamespace('plugins/contract-management')->loadHelpers();
    }
    public function boot(): void
    {
        SlugHelper::registerModule(ContractManagement::class, 'Trang hợp đồng');

        SlugHelper::setPrefix(ContractManagement::class, 'hop-dong', true);
        $this
            ->setNamespace('plugins/contract-management')
            ->loadHelpers()
            ->loadAndPublishConfigurations(["permissions"])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();

            DashboardMenu::default()->beforeRetrieving(function () {
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-contract-management',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'Quản lí hợp đồng',
                    'icon' => 'fa fa-list',
                    'url' => route('contract-management.index'),
                    'permissions' => ['contract-management.index'],
                ]);
            });
    }
}
