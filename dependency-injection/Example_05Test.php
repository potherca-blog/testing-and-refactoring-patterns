<?php

namespace Potherca\Example\DependencyInjection;

use PHPUnit\Framework\TestCase;

class Example_05Test extends TestCase
{
    public function testTrue(): void
    {
        $example = new Example_05();

        $actual = $example->callMember();

        $this->assertTrue($actual);
    }

    public function testFalse(): void
    {
        $mockMember = $this->getMockBuilder(Member::class)
            ->getMock()
        ;

        $mockMember->expects($this->atLeastOnce())
            ->method('call')
            ->willReturn(false)
        ;

        $example = new Example_05($mockMember);

        $actual = $example->callMember();

        $this->assertFalse($actual);
    }
}
