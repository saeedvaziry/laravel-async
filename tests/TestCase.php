<?php

namespace SaeedVaziry\LaravelAsync\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SaeedVaziry\LaravelAsync\LaravelAsyncServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelAsyncServiceProvider::class,
        ];
    }
}
