<?php

namespace Dev\Widget\Misc;

use Dev\Widget\AbstractWidget;
use Exception;

class InvalidWidgetClassException extends Exception
{
    protected $message = 'Widget class must extend class ' . AbstractWidget::class;
}
