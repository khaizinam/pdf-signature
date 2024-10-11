<?php

namespace Dev\Projects\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Base\Facades\DashboardMenu;
use Dev\Projects\Models\Projects;

class ProjectsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/projects')
            ->loadHelpers()
            ->loadAndPublishConfigurations(["permissions"])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();
            
            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                \Dev\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Projects::class, [
                    'name',
                ]);
            }
            
            DashboardMenu::default()->beforeRetrieving(function () {
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-projects',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'plugins/projects::projects.name',
                    'icon' => 'fa fa-list',
                    'url' => route('projects.index'),
                    'permissions' => ['projects.index'],
                ]);
            });
    }
}
