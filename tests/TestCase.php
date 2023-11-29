<?php

namespace SaeedVaziry\LaravelAsync\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SaeedVaziry\LaravelAsync\LaravelAsyncServiceProvider;

class TestCase extends Orchestra
{
    /**
     * Add the service provider in test environment
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelAsyncServiceProvider::class,
        ];
    }
}
