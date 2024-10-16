<?php

namespace Dev\Language\Listeners;

use Dev\Base\Events\CreatedContentEvent;
use Dev\Language\Listeners\Concerns\EnsureThemePackageExists;
use Dev\Language\Models\Language;
use Dev\Setting\Models\Setting;
use Dev\Theme\Events\RenderingThemeOptionSettings;
use Dev\Theme\Facades\ThemeOption;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class CopyThemeOptions
{
    use EnsureThemePackageExists;

    public function handle(CreatedContentEvent $event): void
    {
        if (! $this->determineIfThemesExists()) {
            return;
        }

        if (! $event->data instanceof Language) {
            return;
        }

        $fromTheme = setting('theme');

        if (! $fromTheme) {
            return;
        }

        $fromThemeKey = 'theme-' . $fromTheme . '-';
        $themeKey = 'theme-' . $fromTheme . '-' . $event->data->lang_code . '-';

        RenderingThemeOptionSettings::dispatch();
        $existsThemeOptionKeys = array_keys(Arr::get(ThemeOption::getFields(), 'theme', []));
        $themeOptions = collect(ThemeOption::getOptions())
            ->filter(
                function (mixed $value, string $key) use ($existsThemeOptionKeys, $fromThemeKey) {
                    return Str::startsWith($key, $fromThemeKey)
                        && in_array(Str::after($key, $fromThemeKey), $existsThemeOptionKeys, true);
                }
            )
            ->toArray();

        if (empty($themeOptions)) {
            return;
        }

        $copiedThemeOptions = [];

        $now = Date::now();

        foreach ($themeOptions as $key => $option) {
            $key = str_replace($fromThemeKey, $themeKey, $key);

            $copiedThemeOptions[] = [
                'key' => $key,
                'value' => $option,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (count($copiedThemeOptions)) {
            Setting::query()
                ->insertOrIgnore($copiedThemeOptions);
        }
    }
}
