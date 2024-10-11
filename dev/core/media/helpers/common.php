<?php

use Dev\Media\Facades\AppMedia;
use Illuminate\Http\UploadedFile;

if (! function_exists('is_image')) {
    /**
     * @deprecated since 5.7
     */
    function is_image(string $mimeType): bool
    {
        return AppMedia::isImage($mimeType);
    }
}

if (! function_exists('get_image_url')) {
    /**
     * @deprecated since 5.7
     */
    function get_image_url(
        string $url,
        ?string $size = null,
        bool $relativePath = false,
        $default = null
    ): ?string {
        return AppMedia::getImageUrl($url, $size, $relativePath, $default);
    }
}

if (! function_exists('get_object_image')) {
    /**
     * @deprecated since 5.7
     */
    function get_object_image(string $image, ?string $size = null, bool $relativePath = false): ?string
    {
        return AppMedia::getImageUrl($image, $size, $relativePath, AppMedia::getDefaultImage());
    }
}

if (! function_exists('app_media_handle_upload')) {
    /**
     * @deprecated since 5.7
     */
    function app_media_handle_upload(?UploadedFile $fileUpload, int|string $folderId = 0, string $path = ''): array
    {
        return AppMedia::handleUpload($fileUpload, $folderId, $path);
    }
}
