<?php

namespace Dev\Translation\Http\Controllers;

use Dev\Base\Facades\Assets;
use Dev\Setting\Http\Controllers\SettingController;
use Dev\Translation\Http\Controllers\Concerns\HasMapTranslationsTable;
use Dev\Translation\Http\Requests\TranslationRequest;
use Dev\Translation\Manager;
use Dev\Translation\Tables\TranslationTable;
use Illuminate\Http\Request;

class TranslationController extends SettingController
{
    use HasMapTranslationsTable;

    public function __construct(protected Manager $manager)
    {
    }

    public function index(Request $request, TranslationTable $translationTable)
    {
        $this->pageTitle(trans('plugins/translation::translation.admin-translations'));

        Assets::addScriptsDirectly('vendor/core/plugins/translation/js/translation.js')
            ->addStylesDirectly('vendor/core/plugins/translation/css/translation.css');

        [$locales, $locale, $defaultLanguage, $translationTable]
            = $this->mapTranslationsTable($translationTable, $request);

        if ($request->expectsJson()) {
            return $translationTable->renderTable();
        }

        return view(
            'plugins/translation::index',
            compact('locales', 'locale', 'defaultLanguage', 'translationTable')
        );
    }

    public function update(TranslationRequest $request)
    {
        $group = $request->input('group');

        $name = $request->input('name');
        $value = $request->input('value');

        [$locale, $key] = explode('|', $name, 2);

        $this->manager->updateTranslation($locale, $group, $key, $value);

        return $this->httpResponse();
    }
}
