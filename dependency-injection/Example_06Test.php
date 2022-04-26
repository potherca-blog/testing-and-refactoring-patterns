<?php

namespace Potherca\Example\DependencyInjection;

use PHPUnit\Framework\TestCase;

class Example_06Test extends TestCase
{
    public function testTrue(): void
    {
        $example = new Example_06();

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

        $example = new Example_06();

        $example->setMember($mockMember);

        $actual = $example->callMember();

        $this->assertFalse($actual);
    }
}
