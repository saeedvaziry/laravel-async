<?php

namespace SaeedVaziry\LaravelAsync;

use Illuminate\Support\Facades\Process;
use Laravel\SerializableClosure\SerializableClosure;

class AsyncProcess
{
    protected ?int $timeout = 60;

    protected string $command;

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

        $this->command = sprintf(
            'php %s laravel-async:exec %s 2>&1 > /dev/null &',
            base_path('artisan'),
            escapeshellarg(serialize($object))
        );

        $this->exec();
    }

    private function exec(): void
    {
        if ($this->timeout) {
            $this->command .= ' echo $!';
        }

        $result = Process::run($this->command);

        $pid = (int) $result->output();

        if ($this->timeout && $pid) {
            $killCommand = sprintf(
                'sleep %d && kill %d 2>&1 > /dev/null &',
                $this->timeout,
                $pid
            );

            Process::run($killCommand);
        }
    }
}
