<?php

namespace Dev\PluginManager\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\PluginManager\Actions\RequirePlugin;
use Dev\PluginManager\Exceptions\ComposerRequireFailedException;
use Dev\PluginManager\Http\Requests\RequirePluginRequest;

class RequirePluginController extends BaseController
{
    public function __invoke(RequirePluginRequest $request, RequirePlugin $requirePlugin): BaseHttpResponse
    {
        try {
            $requirePlugin($request->input('name'));

            return $this
                ->httpResponse()
                ->setMessage(__('Plugin has been installed successfully.'));
        } catch (ComposerRequireFailedException $e) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($e->guessCause());
        }
    }
}
