<?php

namespace SaeedVaziry\LaravelAsync\Fakers;

use Laravel\SerializableClosure\SerializableClosure;
use PHPUnit\Framework\Assert;


class AsyncProcessFake
{
    protected ?int $timeout = 60;

    protected array $commands = [];

    public function withoutTimeout(): self
    {
        $this->timeout = null;

        return $this;
    }

    public function timeout(?int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function dispatch(mixed $object): void
    {
        if ($object instanceof \Closure) {
            $object = new SerializableClosure($object);
        }

        $command = sprintf(
            'php %s laravel-async:exec %s 2>&1 > /dev/null &',
            base_path('artisan'),
            escapeshellarg(serialize($object))
        );


        if ($this->timeout) {
            $command .= ' echo $!';
        }

        $this->commands[] = $command;

        if ($this->timeout) {
            $this->commands[] = sprintf(
                'sleep %d && kill %d 2>&1 > /dev/null &',
                $this->timeout,
                10
            );
        }
    }

    public function assertDispatchedCounts(int $count): void
    {
        Assert::assertEquals($count, count($this->commands));
    }

    public function assertExecutedCommandContains(string $command): void
    {
        $contains = false;
        foreach ($this->commands as $executedCommand) {
            if (str_contains($executedCommand, $command)) {
                $contains = true;
            }
        }

        Assert::assertTrue($contains);
    }
}
