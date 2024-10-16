<?php

namespace Dev\PluginManager\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';

    case Running = 'running';

    case Success = 'success';

    case Failed = 'failed';
}
