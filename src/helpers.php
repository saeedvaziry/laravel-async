<?php

use SaeedVaziry\LaravelAsync\Helpers\AsyncProcess;

if (! function_exists('async')) {
    function async(mixed $object): AsyncProcess
    {
        return new AsyncProcess($object);
    }
}
