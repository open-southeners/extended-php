<?php

namespace OpenSoutheners\ExtendedPhp\Tests\Fixtures;

class MyClass implements MyInterface
{
    use MyTrait;

    public function getAnotherClass($foo)
    {
        return new MyOtherClass($foo);
    }

    public function method()
    {
        return true;
    }

    public function methodWithArgs($foo, $bar)
    {
        return compact('foo', 'bar');
    }

    public static function staticMethod()
    {
        return true;
    }

    public static function staticMethodWithArgs($foo, $bar)
    {
        return compact('foo', 'bar');
    }

    protected function hidden()
    {
        return true;
    }

    protected static function staticHidden()
    {
        return true;
    }
}
