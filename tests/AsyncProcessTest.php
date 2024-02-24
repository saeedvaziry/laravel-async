<?php

namespace SaeedVaziry\LaravelAsync\Tests;

use SaeedVaziry\LaravelAsync\Facades\AsyncHandler;

class AsyncProcessTest extends TestCase
{
    public function test_dispatch_with_default_timeout()
    {
        AsyncHandler::fake();

        AsyncHandler::dispatch(function () {
            echo 'test';
        });

        AsyncHandler::assertDispatchedCounts(2);

        AsyncHandler::assertExecutedCommandContains('2>&1 > /dev/null &');
    }

    public function test_dispatch_without_timeout()
    {
        AsyncHandler::fake();

        AsyncHandler::withoutTimeout()->dispatch(function () {
            echo 'test';
        });

        AsyncHandler::assertDispatchedCounts(1);
    }

    public function test_dispatch_with_custom_timeout()
    {
        AsyncHandler::fake();

        AsyncHandler::timeout(10)->dispatch(function () {
            echo 'test';
        });

        AsyncHandler::assertDispatchedCounts(2);

        AsyncHandler::assertExecutedCommandContains('sleep 10');
    }

    public function test_dispatch_with_default_php_binary()
    {
        $binary = PHP_BINARY;

        AsyncHandler::fake();

        AsyncHandler::dispatch(fn () => 'test');

        AsyncHandler::assertExecutedCommandContains($binary);
    }

    public function test_dispatch_with_custom_php_binary()
    {
        config()->set('laravel-async.php_path', '/path/to/php');

        AsyncHandler::fake();

        AsyncHandler::dispatch(fn () => 'test');

        AsyncHandler::assertExecutedCommandContains('/path/to/php');
    }
}
