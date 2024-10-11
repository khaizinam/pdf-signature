<?php

namespace Dev\Installer\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Installer\Supports\RequirementsChecker;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class RequirementController extends BaseController
{
    public function index(Request $request, RequirementsChecker $requirements): View|RedirectResponse
    {
        if (! URL::hasValidSignature($request)) {
            return redirect()->route('installers.welcome');
        }

        $phpSupportInfo = $requirements->checkPhpVersion(get_minimum_php_version());
        $requirements = $requirements->check(config('libs.installer.installer.requirements'));

        return view('libs/installer::.requirements', compact('requirements', 'phpSupportInfo'));
    }
}
