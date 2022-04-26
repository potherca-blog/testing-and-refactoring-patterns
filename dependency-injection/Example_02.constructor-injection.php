<?php

namespace Potherca\Example\DependencyInjection;

class Example_02
{
    private $member;

    public function __construct(Member $member=null)
    {
        $this->member = $member ?: new Member();
    }

    public function callMember(): bool
    {
        return $this->member->call();
    }
}
