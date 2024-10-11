<?php

namespace Dev\Slug\Http\Controllers;

use Dev\Menu\Facades\Menu;
use Dev\Setting\Http\Controllers\SettingController;
use Dev\Setting\Supports\SettingStore;
use Dev\Slug\Events\UpdatedPermalinkSettings;
use Dev\Slug\Forms\SlugSettingForm;
use Dev\Slug\Http\Requests\SlugRequest;
use Dev\Slug\Http\Requests\SlugSettingsRequest;
use Dev\Slug\Models\Slug;
use Dev\Slug\Services\SlugService;
use Illuminate\Support\Str;

class SlugController extends SettingController
{
    public function store(SlugRequest $request, SlugService $slugService)
    {
        return $slugService->create(
            $request->input('value'),
            $request->input('slug_id'),
            $request->input('model')
        );
    }

    public function edit()
    {
        $this->pageTitle(trans('libs/slug::slug.settings.title'));

        return SlugSettingForm::create()->renderForm();
    }

    public function update(SlugSettingsRequest $request, SettingStore $settingStore)
    {
        $hasChangedEndingUrl = false;

        foreach ($request->except(['_token', 'ref_lang']) as $settingKey => $settingValue) {
            if (Str::contains($settingKey, '-model-key')) {
                continue;
            }

            if (Str::startsWith($settingKey, 'public_single_ending_url')) {
                if ($settingValue) {
                    $settingValue = ltrim($settingValue, '.');
                }

                if ($settingStore->get($settingKey) !== $settingValue) {
                    $hasChangedEndingUrl = true;
                }
            }

            $prefix = (string) $settingValue;
            $reference = $request->input($settingKey . '-model-key');

            if ($reference && $settingStore->get($settingKey) !== $prefix) {
                if (! $request->filled('ref_lang')) {
                    Slug::query()
                        ->where('reference_type', $reference)
                        ->update(['prefix' => $prefix]);
                }

                event(new UpdatedPermalinkSettings($reference, $prefix, $request));

                Menu::clearCacheMenuItems();
            }

            $settingStore->set($settingKey, $prefix);
        }

        $settingStore->save();

        if ($hasChangedEndingUrl) {
            Menu::clearCacheMenuItems();
        }

        return $this
            ->httpResponse()
            ->setPreviousRoute('slug.settings')
            ->withUpdatedSuccessMessage();
    }
}
