<?php

namespace Dev\Media\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Media\Chunks\Exceptions\UploadMissingFileException;
use Dev\Media\Chunks\Handler\DropZoneUploadHandler;
use Dev\Media\Chunks\Receiver\FileReceiver;
use Dev\Media\Facades\AppMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

/**
 * @since 19/08/2015 07:50 AM
 */
class MediaFileController extends BaseController
{
    public function postUpload(Request $request)
    {
        try {
            if (! AppMedia::isChunkUploadEnabled()) {
                $result = AppMedia::handleUpload(Arr::first($request->file('file')), $request->input('folder_id', 0));

                return $this->handleUploadResponse($result);
            }

            // Create the file receiver
            $receiver = new FileReceiver('file', $request, DropZoneUploadHandler::class);
            // Check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }
            // Receive the file
            $save = $receiver->receive();
            // Check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                $result = AppMedia::handleUpload($save->getFile(), $request->input('folder_id', 0));

                return $this->handleUploadResponse($result);
            }
            // We are in chunk mode, lets send the current progress
            $handler = $save->handler();

            return response()->json([
                'done' => $handler->getPercentageDone(),
                'status' => true,
            ]);
        } catch (Throwable $exception) {
            return AppMedia::responseError($exception->getMessage());
        }
    }

    protected function handleUploadResponse(array $result): JsonResponse
    {
        if (! $result['error']) {
            return AppMedia::responseSuccess([
                'id' => $result['data']->id,
                'src' => AppMedia::url($result['data']->url),
            ]);
        }

        return AppMedia::responseError($result['message']);
    }

    public function postUploadFromEditor(Request $request)
    {
        return AppMedia::uploadFromEditor($request);
    }

    public function postDownloadUrl(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'url' => ['required', 'url'],
            'folderId' => ['nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            return AppMedia::responseError($validator->messages()->first());
        }

        $result = AppMedia::uploadFromUrl($request->input('url'), $request->input('folderId', 0));

        if (! $result['error']) {
            return AppMedia::responseSuccess([
                'id' => $result['data']->id,
                'src' => Storage::url($result['data']->url),
                'url' => $result['data']->url,
                'message' => trans('core/media::media.javascript.message.success_header'),
            ]);
        }

        return AppMedia::responseError($result['message']);
    }
}
