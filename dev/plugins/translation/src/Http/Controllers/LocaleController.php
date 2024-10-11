<?php

namespace Dev\Translation\Http\Controllers;

use Dev\Base\Exceptions\FileNotWritableException;
use Dev\Base\Facades\Assets;
use Dev\Base\Services\DeleteLocaleService;
use Dev\Base\Supports\Breadcrumb;
use Dev\Base\Supports\Language;
use Dev\Setting\Http\Controllers\SettingController;
use Dev\Translation\Http\Requests\LocaleRequest;
use Dev\Translation\Services\CreateLocaleService;
use Dev\Translation\Services\DownloadLocaleService;
use Illuminate\Support\Facades\File;
use Throwable;

class LocaleController extends SettingController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/translation::translation.locales'), route('translations.locales'));
    }

    public function index()
    {
        $this->pageTitle(trans('plugins/translation::translation.locales'));

        Assets::addScriptsDirectly('vendor/core/plugins/translation/js/locales.js');

        $existingLocales = Language::getAvailableLocales();
        $flags = Language::getListLanguageFlags();

        $locales = Language::getLocales();

        return view('plugins/translation::locales', compact('existingLocales', 'locales', 'flags'));
    }

    public function store(LocaleRequest $request, CreateLocaleService $createLocaleService)
    {
        $locale = $request->input('locale');

        if (! File::isDirectory(lang_path($locale))) {
            $createLocaleService->handle($locale);
        }

        return $this
            ->httpResponse()
            ->withCreatedSuccessMessage();
    }

    public function destroy(string $locale, DeleteLocaleService $deleteLocaleService)
    {
        try {
            $deleteLocaleService->handle($locale);

            return $this
                ->httpResponse()
                ->withDeletedSuccessMessage();
        } catch (FileNotWritableException $e) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($e->getMessage());
        }
    }

    public function download(string $locale, DownloadLocaleService $downloadLocaleService)
    {
        try {
            $file = $downloadLocaleService->handle($locale);

            return response()->download($file)->deleteFileAfterSend();
        } catch (Throwable $exception) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
