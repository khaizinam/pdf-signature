<?php

namespace Dev\Translation\Http\Controllers;

use Dev\DataSynchronize\Http\Controllers\ImportController;
use Dev\DataSynchronize\Importer\Importer;
use Dev\Translation\Importers\OtherTranslationImporter;

class ImportOtherTranslationController extends ImportController
{
    protected function getImporter(): Importer
    {
        return OtherTranslationImporter::make();
    }
}
