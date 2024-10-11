<?php

namespace Dev\Translation\Http\Controllers;

use Dev\DataSynchronize\Exporter\Exporter;
use Dev\DataSynchronize\Http\Controllers\ExportController;
use Dev\Translation\Exporters\ThemeTranslationExporter;

class ExportThemeTranslationController extends ExportController
{
    protected function getExporter(): Exporter
    {
        return ThemeTranslationExporter::make();
    }
}
