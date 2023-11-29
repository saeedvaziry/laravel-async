<?php

namespace SaeedVaziry\LaravelAsync;

use Illuminate\Support\ServiceProvider;
use SaeedVaziry\LaravelAsync\Commands\ExecCommand;

class LaravelAsyncServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerCommands();
    }

    private function registerCommands(): void
    {
        $this->commands([
            ExecCommand::class,
        ]);
    }
}
