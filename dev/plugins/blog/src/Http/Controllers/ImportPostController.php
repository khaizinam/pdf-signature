<?php

namespace Dev\Blog\Http\Controllers;

use Dev\Blog\Importers\PostImporter;
use Dev\DataSynchronize\Http\Controllers\ImportController;
use Dev\DataSynchronize\Importer\Importer;

class ImportPostController extends ImportController
{
    protected function getImporter(): Importer
    {
        return PostImporter::make();
    }
}
