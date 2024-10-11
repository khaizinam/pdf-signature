<?php

namespace Dev\VigReactions\Repositories\Caches;

use Dev\Support\Repositories\Caches\CacheAbstractDecorator;
use Dev\VigReactions\Repositories\Interfaces\VigReactionsInterface;

class VigReactionsCacheDecorator extends CacheAbstractDecorator implements VigReactionsInterface
{
    public function advancedGetReaction(array $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
