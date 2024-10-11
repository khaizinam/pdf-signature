<?php

namespace Dev\Table\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Table\TableBuilder;

class TableController extends BaseController
{
    public function __construct(protected TableBuilder $tableBuilder)
    {
    }
}
