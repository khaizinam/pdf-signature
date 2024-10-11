<?php

namespace Dev\Base\Contracts;

interface HasTreeCategory
{
    public static function updateTree(array $data): void;
}
