<?php

namespace Dev\Location\Providers;

use Dev\Base\Facades\Assets;
use Dev\Base\Forms\FormAbstract;
use Dev\Base\Forms\FormHelper;
use Dev\Base\Supports\ServiceProvider;
use Dev\DataSynchronize\Importer\Importer;
use Dev\Location\Facades\Location;
use Dev\Location\Fields\SelectLocationField;
use Dev\Location\Importers\LocationImporter;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function () {
            add_filter('form_custom_fields', function (FormAbstract $form, FormHelper $formHelper) {
                if (! $formHelper->hasCustomField('selectLocation')) {
                    $form->addCustomField('selectLocation', SelectLocationField::class);
                }

                return $form;
            }, 29, 2);

            add_filter('data_synchronize_import_page_before', function (?string $html, Importer $importer) {
                if (! $importer instanceof LocationImporter) {
                    return $html;
                }

                Assets::addScriptsDirectly('vendor/core/plugins/location/js/bulk-import.js');
                $countries = Location::getAvailableCountries();

                return $html . view('plugins/location::partials.import-available-data', compact('countries'));
            }, 999, 2);
        });
    }
}
