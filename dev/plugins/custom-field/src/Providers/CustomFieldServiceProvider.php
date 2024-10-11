<?php

namespace Dev\CustomField\Providers;

use Dev\ACL\Models\Role;
use Dev\ACL\Models\User;
use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Blog\Models\Category;
use Dev\Blog\Models\Post;
use Dev\CustomField\Facades\CustomField as CustomFieldFacade;
use Dev\CustomField\Models\CustomField;
use Dev\CustomField\Models\FieldGroup;
use Dev\CustomField\Models\FieldItem;
use Dev\CustomField\Repositories\Eloquent\CustomFieldRepository;
use Dev\CustomField\Repositories\Eloquent\FieldGroupRepository;
use Dev\CustomField\Repositories\Eloquent\FieldItemRepository;
use Dev\CustomField\Repositories\Interfaces\CustomFieldInterface;
use Dev\CustomField\Repositories\Interfaces\FieldGroupInterface;
use Dev\CustomField\Repositories\Interfaces\FieldItemInterface;
use Dev\CustomField\Support\CustomFieldSupport;
use Dev\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Dev\Page\Models\Page;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;

class CustomFieldServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        AliasLoader::getInstance()->alias('CustomField', CustomFieldFacade::class);

        $this->app->bind(CustomFieldInterface::class, function () {
            return new CustomFieldRepository(new CustomField());
        });

        $this->app->bind(FieldGroupInterface::class, function () {
            return new FieldGroupRepository(new FieldGroup());
        });

        $this->app->bind(FieldItemInterface::class, function () {
            return new FieldItemRepository(new FieldItem());
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/custom-field')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(EventServiceProvider::class);

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-custom-field',
                    'priority' => 400,
                    'name' => 'plugins/custom-field::base.admin_menu.title',
                    'icon' => 'ti ti-table-options',
                    'route' => 'custom-fields.index',
                ]);
        });

        $this->app['events']->listen(RouteMatched::class, function () {
            $this->registerUsersFields();
            $this->registerPagesFields();

            if (is_plugin_active('blog')) {
                $this->registerBlogFields();
            }
        });

        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(CustomField::class, [
                'value',
            ]);
        }

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }

    protected function registerUsersFields(): CustomFieldSupport
    {
        return CustomFieldFacade::registerRule(
            'other',
            trans('plugins/custom-field::rules.logged_in_user'),
            'logged_in_user',
            function () {
                $users = User::query()->get();
                $userArr = [];
                foreach ($users as $user) {
                    $userArr[$user->id] = $user->username . ' - ' . $user->email;
                }

                return $userArr;
            }
        )
            ->registerRule(
                'other',
                trans('plugins/custom-field::rules.logged_in_user_has_role'),
                'logged_in_user_has_role',
                function () {
                    $roles = Role::query()->get();
                    $rolesArr = [];
                    foreach ($roles as $role) {
                        $rolesArr[$role->slug] = $role->name . ' - (' . $role->slug . ')';
                    }

                    return $rolesArr;
                }
            );
    }

    protected function registerPagesFields(): bool|CustomFieldSupport
    {
        if (! defined('PAGE_MODULE_SCREEN_NAME')) {
            return false;
        }

        return CustomFieldFacade::registerRule(
            'basic',
            trans('plugins/custom-field::rules.page_template'),
            'page_template',
            function () {
                return get_page_templates();
            }
        )
            ->registerRule('basic', trans('plugins/custom-field::rules.page'), Page::class, function () {
                return Page::query()
                    ->select([
                        'id',
                        'name',
                    ])
                    ->orderByDesc('created_at')
                    ->pluck('name', 'id')
                    ->toArray();
            })
            ->expandRule('other', trans('plugins/custom-field::rules.model_name'), 'model_name', function () {
                return [
                    Page::class => trans('plugins/custom-field::rules.model_name_page'),
                ];
            });
    }

    protected function registerBlogFields(): bool|CustomFieldSupport
    {
        if (! defined('POST_MODULE_SCREEN_NAME')) {
            return false;
        }

        return CustomFieldFacade::registerRuleGroup('blog')
            ->registerRule('blog', trans('plugins/custom-field::rules.category'), Category::class, function () {
                return $this->getBlogCategoryIds();
            })
            ->registerRule(
                'blog',
                trans('plugins/custom-field::rules.post_with_related_category'),
                Post::class . '_post_with_related_category',
                function () {
                    return $this->getBlogCategoryIds();
                }
            )
            ->registerRule(
                'blog',
                trans('plugins/custom-field::rules.post_format'),
                Post::class . '_post_format',
                function () {
                    $formats = [];
                    foreach (get_post_formats() as $key => $format) {
                        $formats[$key] = $format['name'];
                    }

                    return $formats;
                }
            )
            ->expandRule('other', trans('plugins/custom-field::rules.model_name'), 'model_name', function () {
                return [
                    Post::class => trans('plugins/custom-field::rules.model_name_post'),
                    Category::class => trans('plugins/custom-field::rules.model_name_category'),
                ];
            });
    }

    protected function getBlogCategoryIds(): array
    {
        $categories = get_categories();

        $categoriesArr = [];
        foreach ($categories as $row) {
            $categoriesArr[$row->id] = $row->indent_text . ' ' . $row->name;
        }

        return $categoriesArr;
    }
}
