<?php

namespace Dev\Media\Events;

use Dev\Media\Models\MediaFile;
use Illuminate\Foundation\Events\Dispatchable;

class MediaFileUploaded
{
    use Dispatchable;

    public function __construct(public MediaFile $file)
    {
    }
}
