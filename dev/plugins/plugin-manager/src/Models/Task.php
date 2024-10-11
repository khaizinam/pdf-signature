<?php

namespace Dev\PluginManager\Models;

use Dev\Base\Models\BaseModel;
use Dev\PluginManager\Enums\TaskOperation;
use Dev\PluginManager\Enums\TaskStatus;

class Task extends BaseModel
{
    protected $table = 'plugin_manager_tasks';

    protected $fillable = [
        'operation',
        'command',
        'package',
        'status',
        'output',
        'started_at',
        'finished_at',
        'peak_memory_used',
    ];

    protected $casts = [
        'operation' => TaskOperation::class,
        'status' => TaskStatus::class,
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}
