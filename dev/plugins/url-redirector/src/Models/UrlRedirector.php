<?php

namespace ArchiElite\UrlRedirector\Models;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Models\BaseModel;

class UrlRedirector extends BaseModel
{
    protected $table = 'url_redirector';

    protected $fillable = [
        'original',
        'target',
        'visits',
    ];

    protected $casts = [
        'original' => SafeContent::class,
        'target' => SafeContent::class,
        'visits' => 'int',
    ];
}
