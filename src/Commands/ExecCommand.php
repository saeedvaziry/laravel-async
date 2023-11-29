<?php

namespace SaeedVaziry\LaravelAsync\Commands;

use Illuminate\Console\Command;
use Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException;
use Laravel\SerializableClosure\SerializableClosure;

class ExecCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-async:exec {object}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executes the object';

    /**
     * @throws PhpVersionNotSupportedException
     */
    public function handle(): void
    {
        $object = unserialize($this->argument('object'));

        // handle closures
        if ($object instanceof SerializableClosure) {
            $object();
        }

        // handle jobs
        if (method_exists($object, 'handle')) {
            $object->handle();
        }
    }
}
