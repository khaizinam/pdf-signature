<?php

namespace Dev\Gallery\Models;

use Dev\Base\Models\BaseModel;

class GalleryMeta extends BaseModel
{
    protected $table = 'gallery_meta';

    protected $casts = [
        'images' => 'json',
    ];
}
