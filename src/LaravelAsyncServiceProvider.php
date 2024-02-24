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

        // merge config file
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-async.php', 'laravel-async');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ExecCommand::class,
            ]);
        }

        // publish config
        $this->publishes([
            __DIR__.'/../config/laravel-async.php' => config_path('laravel-async.php'),
        ], ['laravel-async-config', 'laravel-config']);
    }
}
