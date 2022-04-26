<?php

namespace Potherca\Example\DependencyInjection;

class Example_01
{
    private $member;

    public function __construct()
    {
        $this->member = new Member();
    }

    public function callMember(): bool
    {
        return $this->member->call();
    }
}
