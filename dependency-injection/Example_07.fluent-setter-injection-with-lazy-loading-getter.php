<?php

namespace Potherca\Example\DependencyInjection;

class Example_07
{
    private $member;

    private function getMember(): Member
    {
        if ($this->member === null) {
            $this->member = new Member();
        }

        return $this->member;
    }

    public function setMember(Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function callMember(): bool
    {
        return $this->getMember()->call();
    }
}
