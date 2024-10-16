<?php

namespace Dev\PluginManager\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\PluginManagement\Services\PluginService;
use Dev\PluginManager\Http\Requests\UpdatePluginRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Throwable;
use ZipArchive;

class UpdatePluginFromFileUploadedController extends BaseController
{
    public function __construct(protected PluginService $pluginService)
    {
    }

    public function __invoke(UpdatePluginRequest $request): BaseHttpResponse
    {
        $filePath = $request->input('file_path');
        $pluginName = $request->input('name');

        if (! File::exists($filePath)) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(__('File not found.'));
        }

        try {
            $zip = new ZipArchive();

            $zip->open($filePath);
        } catch (Throwable) {
            tap(
                throw ValidationException::withMessages(['zip_file' => __('This is not a valid zip file.')]),
                fn () => File::delete($filePath)
            );
        }

        File::delete(plugin_path($pluginName));

        $zip->extractTo(plugin_path($pluginName));

        $zip->close();

        File::delete($filePath);

        return $this
            ->httpResponse()
            ->setNextRoute('plugins.index')
            ->withUpdatedSuccessMessage();
    }
}
