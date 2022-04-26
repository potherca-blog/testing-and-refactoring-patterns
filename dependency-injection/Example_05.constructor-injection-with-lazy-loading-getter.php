<?php

namespace Potherca\Example\DependencyInjection;

class Example_05
{
    private $member;

    private function getMember(): Member
    {
        if ($this->member === null) {
            $this->member = new Member();
        }

        return $this->member;
    }

    public function __construct(Member $member=null)
    {
        $this->member = $member;
    }

    public function callMember(): bool
    {
        return $this->getMember()->call();
    }
}
