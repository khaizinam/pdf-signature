<?php

namespace Dev\Media\Events;

use Dev\Media\Models\MediaFolder;
use Illuminate\Foundation\Events\Dispatchable;

class MediaFolderRenaming
{
    use Dispatchable;

    public function __construct(public MediaFolder $file, public string $newName, public bool $renameOnDisk)
    {
    }
}
