<?php

namespace Potherca\Example\DependencyInjection;

class Example_03
{
    private $member;

    public function setMember(Member $member): void
    {
        $this->member = $member;
    }

    public function __construct()
    {
        $this->member = new Member();
    }

    public function callMember(): bool
    {
        return $this->member->call();
    }
}
