<?php

namespace Dev\Location\Http\Controllers;

use Dev\Base\Facades\BaseHelper;
use Dev\DataSynchronize\Http\Controllers\ImportController;
use Dev\DataSynchronize\Importer\Importer;
use Dev\Location\Facades\Location;
use Dev\Location\Http\Requests\ImportLocationRequest;
use Dev\Location\Importers\LocationImporter;

class ImportLocationController extends ImportController
{
    protected function getImporter(): Importer
    {
        return LocationImporter::make();
    }

    public function importLocationData(ImportLocationRequest $request)
    {
        BaseHelper::maximumExecutionTimeAndMemoryLimit();

        $result = Location::downloadRemoteLocation(
            strtolower($request->input('country_code')),
            $request->boolean('continue')
        );

        return $this
            ->httpResponse()
            ->setError($result['error'])
            ->setMessage($result['message']);
    }
}
