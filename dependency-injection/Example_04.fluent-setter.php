<?php

namespace Potherca\Example\DependencyInjection;

class Example_04
{
    private $member;

    public function setMember(Member $member): self
    {
        $this->member = $member;

        return $this;
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
