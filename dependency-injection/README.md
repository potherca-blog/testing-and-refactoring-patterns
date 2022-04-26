# Dependency Injection

It is common for code to contain hard-coded dependency creation.  This is basically any time a new object is created inside a class or function.

However, when such code is to be tested, this can be a problem, as the hard-coded instantiation makes it impossible to use a mock (or test double) instead of the concrete class.

Let's take [the following class](./Example_01.php) as an example:

```php
<?php

class Example
{
    private Member $member;

    public function __construct()
    {
        $this->member = new Member();
    }

    public function callMember(): bool
    {
        return $this->member->call();
    }
}
```

The result of the `callMember()` method is provided by the `Member` class which  is populated in the constructor with a hard-coded `new Member()`.

How can the code of `Example` be changed, without the need of existing code that calls `Example->callMember()` to change?

In broad terms, there are three ways to solve this problem:

1. Inject the dependency into the constructor.
2. Inject the dependency using a setter method.
3. Use a lazy-loading getter method

Which solution is the best for which scenario depends on a balance between how much code needs to be changed _now_ in order to make tests, and how much code will need to be changed _in the future_ when the dependency is injected in existing production code.

As far as design patterns go, dependencies that a class MUST have in order to function SHOULD be injected into the constructor. That way, the class is guaranteed to work once it has been instantiated. 

However, as life is not always that straightforward, this _might_ not always be possible.

## Constructor injection

The easiest solution is to [change the example](./Example_02.constructor-injection.php) so we can inject the dependency into the constructor, with a fallback to the existing hard-coded dependency if nothing is injected:

```php
    public function __construct(Member $member=null)
    {
        $this->member = $member ?: new Member();
    }
```

This way, the test can inject a mock, whilst the rest of the existing code will continue to work as before.

This also allows changing existing calls to `Example->callMember()` one-at-a-time.

```php
// Before refactor
$example = new Example();
$result = $example->callMember();
```

```php
// After refactor
$member = new Member();
$example = new Example($member);
$result = $example->callMember();
```

Usually this is the way to go. There are cases where this is not possible.
For instance when the class implements an interface (or extends an abstract parent), or there are other reasons the constructor can not be changed.

In those cases, setter injection will need to be used.

## Setter injection

Adding [a setter method to the class](./Example_03.setter-injection.php) is also a small change:

```php
    public function setMember(Member $member): void
    {
        $this->member = $member;
    }
```

This way, after instantiating the class, the test code can inject a mock instead of the hard-coded dependency.

```php
// Before refactor
$example = new Example();
$result = $example->callMember();
```

```php
// After refactor
$member = new Member();
$example = new Example();
$example->setMember($member);
$result = $example->callMember();
```

Depending on the development style used in the project, the setter can also [be made fluent](./Example_04.fluent-setter.php), so the calling code can [chain calls](https://en.wikipedia.org/wiki/Method_chaining) to the setter.

<sup>(Before deciding to use a fluent setter, please read [Fluent interfaces are evil](https://ocramius.github.io/blog/fluent-interfaces-are-evil/))</sup>

```php
// After refactor with a fluent setter
$member = new Member();
$example = new Example();
$result = $example->setMember($member)->callMember();
```

However, the setter solution can cause problems when the rest of the existing code that calls `Example->callMember()` needs to be changed.

If even one instance of `setMember` is overlooked, the code will be broken.
This means all the existing code that calls `Example->callMember()` will need to be changed at the same time. Depending on the amount of calls, this can be expensive.

This risk can be decreased by using lazy loading.

## Lazy-loading getter

This is the implementation that requires the most changes in the class that is being tested.

Lazy loading means that, instead of requiring the dependency to be present when the class is instantiated, the dependency is not created (or checked) until the first time it is accessed.

The way this is done, is by replacing direct access to `$this->member` with a private getter method:

```php
    public function callMember(): bool
    {
        return $this->getMember()->call();
    }
```

The getter method will check whether `Member` has been created.
If not, it will create it and assign it to `$this->member`.

```php
    private function getMember(): Member
    {
        if (!$this->member) {
            $this->member = new Member();
        }

        return $this->member;
    }
``` 

A lazy loading getter can be combined with both the constructor and setter injection examples given above.

For [constructor injection with lazy loading](./Example_05.constructor-injection-with-lazy-loading-getter.php), as the default is provided by the getter, the hard-coded default is no longer needed:

```php
    public function __construct(Member $member=null)
    {
        $this->member = $member;
    }
```

When [lazy loading with setter injection](./Example_06.setter-injection-with-lazy-loading-getter.php) (or [with a fluent setter](./Example_07.fluent-setter-injection-with-lazy-loading-getter.php)) nothing changes from the given example (other than the getter being added).

In both cases, existing code calls to `Example->callMember()` do not need to be changed in order for things to work.

## Conclusion

Code examples and tests have been provided for all the scenarios described above.

When you encounter code with hard-coded dependencies that you want to write tests for, take a moment to consider which solution is the best fit.

Happy coding!

## Footnotes

1. You can read more about Fluent Interfaces on [Wikipedia](https://en.wikipedia.org/wiki/Fluent_interface).

###### tags: `dependencies`, `dependency-injection`, `fluent-interface`, `hard-coding`, `lazy-loading`, `refator-pattern`
