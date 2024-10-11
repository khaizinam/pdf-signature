<?php

namespace Dev\ElasticsearchLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class ElasticsearchLaravelFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'es-makeindex';
    }
}
