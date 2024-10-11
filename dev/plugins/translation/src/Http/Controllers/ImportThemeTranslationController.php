<?php

namespace Dev\Translation\Http\Controllers;

use Dev\DataSynchronize\Http\Controllers\ImportController;
use Dev\DataSynchronize\Importer\Importer;
use Dev\Translation\Importers\ThemeTranslationImporter;

class ImportThemeTranslationController extends ImportController
{
    protected function getImporter(): Importer
    {
        return ThemeTranslationImporter::make();
    }
}
