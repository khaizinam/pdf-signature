<?php

namespace Dev\ElasticsearchLaravel\Repositories\Caches;

use Dev\Support\Repositories\Caches\CacheAbstractDecorator;
use Dev\ElasticsearchLaravel\Repositories\Interfaces\PostInterface;

class PostCacheDecorator extends CacheAbstractDecorator implements PostInterface
{
    /**
     * {@inheritDoc}
     */
}
