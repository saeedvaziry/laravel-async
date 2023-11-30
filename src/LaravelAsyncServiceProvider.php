<?php

namespace SaeedVaziry\LaravelAsync;

use Illuminate\Support\ServiceProvider;
use SaeedVaziry\LaravelAsync\Commands\ExecCommand;

class LaravelAsyncServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('async-handler', function () {
            return new AsyncProcess();
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ExecCommand::class,
            ]);
        }
    }
}
