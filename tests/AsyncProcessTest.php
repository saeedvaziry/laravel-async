<?php

namespace SaeedVaziry\LaravelAsync\Tests;

class AsyncProcessTest extends TestCase
{
    public function testConstructWithClosure()
    {
        $async = async(function () {
            echo "test";
        });

        $reflection = new \ReflectionClass($async);

        $this->assertNotEmpty($reflection->getProperty('command')->getValue($async));
    }

    public function testSetTimeout()
    {
        $async = async(function () {
            echo "test";
        })->timeout(10);

        $reflection = new \ReflectionClass($async);

        $this->assertEquals(10, $reflection->getProperty('timeout')->getValue($async));
    }

    public function testSetWithoutTimeout()
    {
        $async = async(function () {
            echo "test";
        })->withoutTimeout();

        $reflection = new \ReflectionClass($async);

        $this->assertNull($reflection->getProperty('timeout')->getValue($async));
    }
}
