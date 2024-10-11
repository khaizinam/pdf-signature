<?php

namespace Dev\Language\Listeners\Concerns;

use Dev\Theme\Theme;

trait EnsureThemePackageExists
{
    public function determineIfThemesExists(): bool
    {
        return class_exists(Theme::class);
    }
}
