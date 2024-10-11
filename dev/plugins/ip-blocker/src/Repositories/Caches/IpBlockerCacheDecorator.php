<?php

namespace ArchiElite\IpBlocker\Repositories\Caches;

use ArchiElite\IpBlocker\Repositories\Interfaces\IpBlockerInterface;
use Dev\Support\Repositories\Caches\CacheAbstractDecorator;

class IpBlockerCacheDecorator extends CacheAbstractDecorator implements IpBlockerInterface
{
}
