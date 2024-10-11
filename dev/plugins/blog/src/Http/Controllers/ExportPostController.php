<?php

namespace Dev\Blog\Http\Controllers;

use Dev\Blog\Exporters\PostExporter;
use Dev\DataSynchronize\Exporter\Exporter;
use Dev\DataSynchronize\Http\Controllers\ExportController;

class ExportPostController extends ExportController
{
    protected function getExporter(): Exporter
    {
        return PostExporter::make();
    }
}
