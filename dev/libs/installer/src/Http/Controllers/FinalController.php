<?php

namespace Dev\Installer\Http\Controllers;

use Dev\Base\Facades\BaseHelper;
use Dev\Installer\Events\InstallerFinished;
use Dev\Installer\Services\CleanupSystemAfterInstalledService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class FinalController
{
    public function index(
        Request $request,
        CleanupSystemAfterInstalledService $cleanupSystemAfterInstalledService
    ): View|RedirectResponse {
        if (! URL::hasValidSignature($request)) {
            return redirect()->route('installers.requirements.index');
        }

        File::delete(storage_path('installing'));

        BaseHelper::saveFileData(storage_path('installed'), Carbon::now()->toDateTimeString());

        $cleanupSystemAfterInstalledService->handle();

        event(new InstallerFinished());

        return view('libs/installer::final');
    }
}
