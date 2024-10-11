<?php

namespace Dev\VigReactions\Repositories\Interfaces;

use Dev\Support\Repositories\Interfaces\RepositoryInterface;

interface VigReactionMetaInterface extends RepositoryInterface
{
    public function saveMetaReactionData($object, $value);

    public function getMetaData($object, array $select = ['value']);

    public function getMeta($object, array $select = ['value']);
}
