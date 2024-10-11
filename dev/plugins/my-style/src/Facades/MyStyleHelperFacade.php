<?php

namespace Dev\MyStyle\Facades;

use Dev\MyStyle\MyStyleHelper;
use Illuminate\Support\Facades\Facade;

class MyStyleHelperFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MyStyleHelper::class;
    }
}
