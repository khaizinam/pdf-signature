<?php

namespace Dev\Turnstile\Providers;

use Dev\ACL\Forms\Auth\ForgotPasswordForm;
use Dev\ACL\Forms\Auth\LoginForm;
use Dev\ACL\Forms\Auth\ResetPasswordForm;
use Dev\ACL\Http\Requests\ForgotPasswordRequest;
use Dev\ACL\Http\Requests\LoginRequest;
use Dev\ACL\Http\Requests\ResetPasswordRequest;
use Dev\Base\Facades\PanelSectionManager;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\PanelSections\PanelSectionItem;
use Dev\Base\Supports\ServiceProvider;
use Dev\Base\Traits\LoadAndPublishDataTrait;
use Dev\Setting\PanelSections\SettingOthersPanelSection;
use Dev\Support\Http\Requests\Request;
use Dev\Theme\FormFront;
use Dev\Turnstile\Contracts\Turnstile as TurnstileContract;
use Dev\Turnstile\Facades\Turnstile as TurnstileFacade;
use Dev\Turnstile\Forms\Fields\TurnstileField;
use Dev\Turnstile\Rules\Turnstile as TurnstileRule;
use Dev\Turnstile\Turnstile;
use Illuminate\Routing\Events\Routing;
use Illuminate\Support\Facades\Event;

class TurnstileServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->singleton(TurnstileContract::class, function () {
            $siteKey = setting('fob_turnstile_site_key');
            $secretKey = setting('fob_turnstile_secret_key');

            return new Turnstile($siteKey, $secretKey);
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/turnstile')
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes()
            ->registerPanelSection()
            ->loadAndPublishConfigurations('permissions')
            ->registerTurnstile();
    }

    protected function registerPanelSection(): self
    {
        PanelSectionManager::default()->beforeRendering(function () {
            PanelSectionManager::registerItem(
                SettingOthersPanelSection::class,
                fn () => PanelSectionItem::make('turnstile')
                    ->setTitle(trans('plugins/turnstile::turnstile.settings.title'))
                    ->withIcon('ti ti-mail-cog')
                    ->withPriority(10)
                    ->withDescription(trans('plugins/turnstile::turnstile.settings.description'))
                    ->withRoute('turnstile.settings')
            );
        });

        return $this;
    }

    protected function registerTurnstile(): self
    {
        TurnstileFacade::registerForm(
            LoginForm::class,
            LoginRequest::class,
            trans('plugins/turnstile::turnstile.forms.admin_login')
        );

        TurnstileFacade::registerForm(
            ForgotPasswordForm::class,
            ForgotPasswordRequest::class,
            trans('plugins/turnstile::turnstile.forms.admin_forgot_password')
        );

        TurnstileFacade::registerForm(
            ResetPasswordForm::class,
            ResetPasswordRequest::class,
            trans('plugins/turnstile::turnstile.forms.admin_reset_password')
        );

        if (! TurnstileFacade::isEnabled()) {
            return $this;
        }

        FormAbstract::beforeRendering(function (FormAbstract $form): void {
            $fieldKey = 'submit';

            if ($form instanceof FormFront) {
                $fieldKey = $form->has($fieldKey) ? $fieldKey : array_key_last($form->getFields());
            }

            if (! TurnstileFacade::isEnabledForForm($form::class)) {
                return;
            }

            $form->addBefore(
                $fieldKey,
                'turnstile',
                TurnstileField::class
            );
        });

        Event::listen(Routing::class, function () {
            add_filter('core_request_rules', function (array $rules, Request $request) {
                TurnstileFacade::getForms();

                if (TurnstileFacade::isEnabledForForm(
                    TurnstileFacade::getFormByRequest($request::class)
                )) {
                    $rules['cf-turnstile-response'] = [new TurnstileRule()];
                }

                return $rules;
            }, 999, 2);

            add_filter('core_request_attributes', function (array $attributes, Request $request) {
                TurnstileFacade::getForms();

                if (TurnstileFacade::isEnabledForForm(
                    TurnstileFacade::getFormByRequest($request::class)
                )) {
                    $attributes['cf-turnstile-response'] = 'Turnstile';
                }

                return $attributes;
            }, 999, 2);
        });

        return $this;
    }
}
