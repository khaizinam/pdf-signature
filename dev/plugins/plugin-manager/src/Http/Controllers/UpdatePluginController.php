<?php

namespace Dev\PluginManager\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\PluginManager\Actions\UpdatePlugin;
use Dev\PluginManager\Exceptions\ComposerUpdateFailedException;
use Dev\PluginManager\Http\Requests\UpdatePluginRequest;

class UpdatePluginController extends BaseController
{
    public function __invoke(UpdatePluginRequest $request, UpdatePlugin $updatePlugin): BaseHttpResponse
    {
        try {
            $updatePlugin($request->input('name'));

            return $this
                ->httpResponse()
                ->setMessage(__('Plugin has been updated successfully.'));
        } catch (ComposerUpdateFailedException) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(__('Failed to execute, please check the composer logs in the storage/logs folder.'));
        }
    }
}
