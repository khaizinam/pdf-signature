<?php

namespace Dev\RequestLog\Providers;

use Dev\Base\Supports\ServiceProvider;
use Dev\RequestLog\Commands\RequestLogClearCommand;
use Dev\RequestLog\Models\RequestLog;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Console\PruneCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            RequestLogClearCommand::class,
        ]);

        $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command(PruneCommand::class, ['--model' => RequestLog::class])->dailyAt('00:30');
        });
    }
}
