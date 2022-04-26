<?php

namespace Potherca\Example\DependencyInjection;

class Example_06
{
    private $member;

    private function getMember(): Member
    {
        if ($this->member === null) {
            $this->member = new Member();
        }

        return $this->member;
    }

    public function setMember(Member $member): void
    {
        $this->member = $member;
    }

    public function callMember(): bool
    {
        return $this->getMember()->call();
    }
}
