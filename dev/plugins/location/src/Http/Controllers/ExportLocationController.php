<?php

namespace Dev\Location\Http\Controllers;

use Dev\DataSynchronize\Exporter\Exporter;
use Dev\DataSynchronize\Http\Controllers\ExportController;
use Dev\Location\Exporters\LocationExporter;

class ExportLocationController extends ExportController
{
    protected function getExporter(): Exporter
    {
        return LocationExporter::make();
    }
}
