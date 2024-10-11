<?php

namespace Dev\Installer\Http\Middleware;

use Dev\Base\Supports\Helper;
use Illuminate\Support\Facades\File;

abstract class InstallerMiddleware
{
    public function alreadyInstalled(): bool
    {
        if (! config('libs.installer.installer.enabled')) {
            return true;
        }

        if (File::exists(storage_path('installed'))) {
            return true;
        }

        return ! File::exists(storage_path('installing')) && Helper::isConnectedDatabase();
    }
}
