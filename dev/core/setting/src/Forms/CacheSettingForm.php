<?php

namespace Dev\Setting\Forms;

use Dev\Base\Forms\FieldOptions\OnOffFieldOption;
use Dev\Base\Forms\Fields\HtmlField;
use Dev\Base\Forms\Fields\OnOffCheckboxField;
use Dev\Setting\Http\Requests\CacheSettingRequest;

class CacheSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setUrl(route('settings.cache.update'))
            ->setSectionTitle(trans('core/setting::setting.cache.title'))
            ->setSectionDescription(trans('core/setting::setting.cache.description'))
            ->setValidatorClass(CacheSettingRequest::class)
            ->add('enable_cache', 'html', [
                'html' => view('core/setting::partials.cache.cache-fields')->render(),
            ])
            ->add(
                'cache_admin_menu_enable',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label(trans('core/setting::setting.cache.form.cache_admin_menu'))
                    ->value(setting('cache_admin_menu_enable', false))
            )
            ->add(
                'cache_front_menu_enabled',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label(trans('core/setting::setting.cache.form.cache_front_menu'))
                    ->helperText(trans('core/setting::setting.cache.form.cache_front_menu_helper'))
                    ->value(setting('cache_front_menu_enabled', true))
            )
            ->add(
                'cache_user_avatar_enabled',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label(trans('core/setting::setting.cache.form.cache_user_avatar'))
                    ->value(setting('cache_user_avatar_enabled', true))
            )
            ->add('enable_site_map_cache', HtmlField::class, [
                'html' => view('core/setting::partials.cache.cache-site-map-fields')->render(),
            ]);
    }
}
