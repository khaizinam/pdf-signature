<?php

namespace Dev\Translation\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Translation\Manager;

class ReImportThemeTranslationController extends BaseController
{
    public function __invoke(Manager $manager)
    {
        $manager->updateThemeTranslations();

        return $this->httpResponse()->setMessage(trans('plugins/translation::translation.import_success_message'));
    }
}
