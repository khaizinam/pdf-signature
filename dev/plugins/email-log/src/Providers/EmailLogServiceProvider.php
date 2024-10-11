<?php

declare(strict_types=1);

namespace Dev\EmailLog\Providers;

use Dev\Base\Facades\DashboardMenu;
use Dev\Base\Forms\FieldOptions\NumberFieldOption;
use Dev\Base\Forms\Fields\NumberField;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Setting\Forms\GeneralSettingForm;
use Illuminate\Support\ServiceProvider;

class EmailLogServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public const MODULE_NAME = 'email-log';

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/email-log')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes()
            ->loadMigrations();

        $this->app->register(EventServiceProvider::class);

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::registerItem([
                'id' => 'email-log',
                'priority' => 5,
                'parent_id' => null,
                'name' => __('Email Logs'),
                'icon' => 'ti ti-mail-opened',
                'url' => route('email-logs.index'),
                'permissions' => ['email-logs.index'],
            ]);
        });

        GeneralSettingForm::extend(function (GeneralSettingForm $form) {
            $form->add(
                'keep_email_log_for_days',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/email-log::email-log.settings.keep_log_for_days'))
                    ->value((string) setting('keep_email_log_for_days', 30))
                    ->helperText(trans('plugins/email-log::email-log.settings.keep_log_for_days_description'))
                    ->toArray()
            );
        });
    }
}
