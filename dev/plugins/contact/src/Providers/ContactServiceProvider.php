<?php

namespace Dev\Contact\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Facades\EmailHandler;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Contact\Models\Contact;
use Dev\Contact\Models\ContactReply;
use Dev\Contact\Models\CustomField;
use Dev\Contact\Models\CustomFieldOption;
use Dev\Contact\Repositories\Eloquent\ContactReplyRepository;
use Dev\Contact\Repositories\Eloquent\ContactRepository;
use Dev\Contact\Repositories\Interfaces\ContactInterface;
use Dev\Contact\Repositories\Interfaces\ContactReplyInterface;
use Dev\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Dev\Setting\PanelSections\SettingOthersPanelSection;
use Illuminate\Routing\Events\RouteMatched;

class ContactServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(ContactInterface::class, function () {
            return new ContactRepository(new Contact());
        });

        $this->app->bind(ContactReplyInterface::class, function () {
            return new ContactReplyRepository(new ContactReply());
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/contact')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions', 'email'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-contact',
                    'priority' => 120,
                    'name' => 'plugins/contact::contact.menu',
                    'icon' => 'ti ti-mail',
                ])
                ->registerItem([
                    'id' => 'cms-plugins-contact-list',
                    'parent_id' => 'cms-plugins-contact',
                    'priority' => 120,
                    'name' => 'plugins/contact::contact.name',
                    'route' => 'contacts.index',
                ])
                ->registerItem([
                    'id' => 'cms-plugins-contact-custom-fields',
                    'parent_id' => 'cms-plugins-contact',
                    'priority' => 130,
                    'name' => 'plugins/contact::contact.custom_field.name',
                    'route' => 'contacts.custom-fields.index',
                    'permissions' => 'contacts.edit',
                ]);
        });

        PanelSectionManager::default()->beforeRendering(function () {
            PanelSectionManager::registerItem(
                SettingOthersPanelSection::class,
                fn () => PanelSectionItem::make('contact')
                    ->setTitle(trans('plugins/contact::contact.settings.title'))
                    ->withIcon('ti ti-mail-cog')
                    ->withPriority(140)
                    ->withDescription(trans('plugins/contact::contact.settings.description'))
                    ->withRoute('contact.settings')
            );
        });

        $this->app['events']->listen(RouteMatched::class, function () {
            EmailHandler::addTemplateSettings(CONTACT_MODULE_SCREEN_NAME, config('plugins.contact.email', []));
        });

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });

        if (defined('LANGUAGE_MODULE_SCREEN_NAME') && defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(CustomField::class, [
                'name',
                'placeholder',
            ]);

            LanguageAdvancedManager::registerModule(CustomFieldOption::class, [
                'label',
                'value',
            ]);

            LanguageAdvancedManager::addTranslatableMetaBox('contact-custom-field-options');
        }
    }
}
