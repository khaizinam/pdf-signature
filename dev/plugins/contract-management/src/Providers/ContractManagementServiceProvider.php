<?php

namespace Dev\ContractManagement\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Base\Facades\DashboardMenu;
use Dev\ContractManagement\Models\ContractManagement;

class ContractManagementServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/contract-management')
            ->loadHelpers()
            ->loadAndPublishConfigurations(["permissions"])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();

            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                \Dev\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(ContractManagement::class, [
                    'name',
                ]);
            }

            DashboardMenu::default()->beforeRetrieving(function () {
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-contract management',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'plugins/contract management::contract management.name',
                    'icon' => 'fa fa-list',
                    'url' => route('contract-management.index'),
                    'permissions' => ['contract-management.index'],
                ]);
            });
    }
}
