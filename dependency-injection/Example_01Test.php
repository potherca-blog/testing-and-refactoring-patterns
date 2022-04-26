<?php

namespace Potherca\Example\DependencyInjection;

use PHPUnit\Framework\TestCase;

class Example_01Test extends TestCase
{
    public function testTrue(): void
    {
        $example = new Example_01();

        $actual = $example->callMember();

        $this->assertTrue($actual);
    }
}
