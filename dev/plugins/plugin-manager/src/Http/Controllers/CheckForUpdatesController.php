<?php

namespace Dev\PluginManager\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\PluginManager\Actions\CheckForUpdates;
use Dev\PluginManager\Exceptions\ComposerCheckForUpdatesFailedException;

class CheckForUpdatesController extends BaseController
{
    public function __invoke(CheckForUpdates $checkForUpdates): BaseHttpResponse
    {
        try {
            $result = $checkForUpdates();

            return $this
                ->httpResponse()
                ->setData($result->toArray());
        } catch (ComposerCheckForUpdatesFailedException) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(__('Failed to execute, please check the composer logs in the storage/logs folder.'));
        }
    }
}
